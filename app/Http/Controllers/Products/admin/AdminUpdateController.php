<?php

namespace App\Http\Controllers\Products\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\adminProducts\ProductsService;
use App\Services\products\GenerateUniqueSlugService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminUpdateController extends Controller
{

    public function __invoke($slug, UpdateProductRequest $request)
    {
        DB::beginTransaction();
        $uploadedPaths = [];

        try {

            $product = Product::where('slug', $slug)->firstOrFail();
            Gate::authorize('update', $product);
            $data = $request->validated();

            // Получаем категорию
            $categoryId = $product->category_id;
            if (array_key_exists('category_slug', $data)) {
                $category = Category::where('slug', $data['category_slug'])->firstOrFail();
                $categoryId = $category->id;
            }

            // Генерируем новую папку
            $productDir = $product->storage_folder;

            // Обработка превью
            $previewPath = $product->preview;
            if ($request->hasFile('preview')) {
                $previewFile = $request->file('preview');
                $previewFilename = 'preview_' . uniqid() . '.' . $previewFile->extension();
                $previewPath = Storage::disk('yandex')->putFileAs($productDir, $previewFile, $previewFilename);

                if (!$previewPath) throw new \Exception('Не удалось загрузить превью');

                // удалить старый превью (если он отличается от нового)
                if ($product->preview && $product->preview !== $previewPath) {
                    Storage::disk('yandex')->delete($product->preview);
                }

                $uploadedPaths[] = $previewPath;
            }

            // Удаление изображений
            $deletedImages = $data['deleted_images'] ?? [];
            foreach ($deletedImages as $imgPath) {
                Storage::disk('yandex')->delete($imgPath);
            }


            // Объединяем старые и новые фото
            $existingPhotos = array_filter($data['existing_photos'] ?? [], fn($photo) => !in_array($photo, $deletedImages));


            // Обработка новых фото
            $newPhotos = [];
            foreach ($request->file('photos') ?? [] as $file) {
                $filename = uniqid('product_') . '.' . $file->extension();
                $storedPath = Storage::disk('yandex')->putFileAs($productDir, $file, $filename);
                if (!$storedPath) throw new \Exception('Не удалось загрузить фото');
                $newPhotos[] = $storedPath;
                $uploadedPaths[] = $storedPath;
            }

            $allPhotos = [...$existingPhotos, ...$newPhotos];
            if (count($allPhotos) < 3) {
                throw new \Exception('Необходимо минимум 3 фотографии');
            }

            // Обновляем продукт
            $product->update([
                'title' => $data['title'] ?? $product->title,
                'description' => $data['description'] ?? $product->description,
                'preview' => $previewPath,
                'photos' => [...$existingPhotos, ...$newPhotos],
                'category_id' => $categoryId,
                'actual_price' => $data['actual_price'] ?? $product->actual_price,
                'old_price' => isset($data['actual_price'])
                    ? ($data['actual_price'] < $product->actual_price ? $product->actual_price : null)
                    : $product->old_price,
                'equipment' => array_key_exists('equipment', $data) ? explode(',', $data['equipment']) : $product->equipment,
                'external_links' => $data['external_links'] ?? $product->external_links,
                'quantity' => $data['quantity'] ?? $product->quantity,
            ]);


            // Синхронизация материалов
            if (array_key_exists('materials', $data)) {
                $product->materials()->sync($data['materials']);
            }

            DB::commit();
            return response()->json('Продукт обновлён', 200);


        } catch (\Exception $e) {
            DB::rollBack();

            // Удаление загруженных файлов в случае ошибки
            foreach ($uploadedPaths as $path) {
                Storage::disk('yandex')->delete($path);
            }

            return response()->json([
                'message' => 'Ошибка при обновлении товара: ' . $e->getMessage()
            ], 500);
        }
    }
}
