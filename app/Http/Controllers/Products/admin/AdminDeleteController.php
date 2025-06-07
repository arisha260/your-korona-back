<?php

namespace App\Http\Controllers\Products\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KoronaNewsRequest;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\KoronaNewResourceLatest;
use App\Models\KoronaNew;
use App\Models\KoronaReview;
use App\Models\Product;
use App\Services\cache\DeleteProductService;
use App\Services\cache\NewsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AdminDeleteController extends Controller
{

    protected $deleteService;

    /**
     * @param $deleteService
     */
    public function __construct(DeleteProductService $deleteService)
    {
        $this->deleteService = $deleteService;
    }


    public function __invoke($slug)
    {

        DB::beginTransaction();
        try {

            $product = Product::with('materials')->where('slug', $slug)->firstOrFail();

            Gate::authorize('delete', $product);

            DB::transaction(function () use ($product) {
                // Удаление preview
                if ($product->preview) {
                    Storage::disk('s3')->delete($product->preview);
                }

                // Удаление фото из массива photos
                if (!empty($product->photos) && is_array($product->photos)) {
                    foreach ($product->photos as $photo) {
                        Storage::disk('s3')->delete($photo);
                    }
                }

                // Удаляем материалы (pivot)
                $product->materials()->detach();

                // Удаляем отзывы, если есть поле product_id
                KoronaReview::where('product_id', $product->id)->delete();

                // Удаляем сам продукт
                $product->delete();
            });

            $this->deleteService->clearCache();
            DB::commit();
            return response()->json(['message' => 'Продукт и все зависимости успешно удалены']);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Ошибка при удалении товара: ' . $e->getMessage()
            ], 500);
            }
    }
}
