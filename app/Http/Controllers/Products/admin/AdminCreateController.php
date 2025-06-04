<?php

namespace App\Http\Controllers\Products\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\adminProducts\ProductsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCreateController extends Controller
{
    public function __invoke(CreateProductRequest $request, ProductsService $productService)
    {

        DB::beginTransaction();

        try {

            $data = $request->validated();

            $category = Category::where('slug', $data['category_slug'])->firstOrFail();

            $photos = [];
            $uniqueSuffix = substr(uniqid(), -6);
            $productDir = 'cover/products/' . Str::slug($data['title']) . '-' . $uniqueSuffix;
            foreach ($request->file('photos') as $photo) {
                $filename = uniqid('product_') . '.' . $photo->extension();

                $storedPath = Storage::disk('yandex')->putFileAs($productDir, $photo, $filename);

                if (!$storedPath) {
                    throw new \Exception('Не удалось загрузить файл на диск');
                }

                $photos[] = $storedPath;
            }

            $product = Product::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'photos' => $photos,
                'category_id' => $category->id,
                'actual_price' => $data['actual_price'],
                'equipment' => $data['equipment'] ? explode(',', $data['equipment']) : null,
                'external_links' => $data['external_links'] ?? null,
                'quantity' => $data['quantity'],
            ]);

            if (!empty($data['materials'])) {
                $product->materials()->sync($data['materials']);
            }

            DB::commit();
            return response()->json('Продукт добавлен', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ошибка при создании товара: ' . $e->getMessage()], 500);
        }
    }
}
