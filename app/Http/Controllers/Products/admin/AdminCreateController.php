<?php

namespace App\Http\Controllers\Products\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\adminProducts\ProductsService;
use App\Services\products\GenerateUniqueSlugService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCreateController extends Controller
{

    public function __invoke(CreateProductRequest $request, ProductsService $productService)
    {

        DB::beginTransaction();

        $uploadedPaths = [];

        try {

            $data = $request->validated();

            $category = Category::where('slug', $data['category_slug'])->firstOrFail();

            $storageFolder = 'cover/products/' . Str::slug($data['title']) . '-' . uniqid();


            $previewFile = $request->file('preview');
            $previewFilename = 'preview_' . uniqid() . '.' . $previewFile->extension();
            $previewPath = Storage::disk('yandex')->putFileAs($storageFolder, $previewFile, $previewFilename);

            if (!$previewPath) {
                throw new \Exception('Не удалось загрузить превью');
            }

            $uploadedPaths[] = $previewPath;


            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $filename = uniqid('product_') . '.' . $photo->extension();

                $storedPath = Storage::disk('yandex')->putFileAs($storageFolder, $photo, $filename);

                if (!$storedPath) {
                    throw new \Exception('Не удалось загрузить файл на диск');
                }

                $photos[] = $storedPath;
                $uploadedPaths[] = $storedPath;
            }

            $product = Product::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'preview' => $previewPath,
                'photos' => $photos,
                'category_id' => $category->id,
                'actual_price' => $data['actual_price'],
                'equipment' => $data['equipment'] ? explode(',', $data['equipment']) : null,
                'external_links' => $data['external_links'] ?? null,
                'quantity' => $data['quantity'],
                'storage_folder' => $storageFolder,
            ]);

            if (!empty($data['materials'])) {
                $product->materials()->sync($data['materials']);
            }

            DB::commit();
            return response()->json('Продукт добавлен', 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Удаление файлов из облака
            foreach ($uploadedPaths as $path) {
                Storage::disk('yandex')->delete($path);
            }

            return response()->json([
                'message' => 'Ошибка при создании товара: ' . $e->getMessage()
            ], 500);
        }
    }
}
