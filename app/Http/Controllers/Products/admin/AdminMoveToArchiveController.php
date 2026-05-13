<?php

namespace App\Http\Controllers\Products\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\adminProducts\ProductsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminMoveToArchiveController extends Controller
{
    public function __invoke($slug, ProductsService $productService)
    {

        $product = Product::where('slug', $slug)->firstOrFail();

        try {

            Gate::authorize('update', $product);

            $product->update([
                'is_archived' => !$product->is_archived,
            ]);

            return response()->json([
                'message' => $product->is_archived
                    ? 'Товар перемещен в архив'
                    : 'Товар извлечен из архива',
                'is_archived' => $product->is_archived
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка при переносе товара в архив: ' . $e->getMessage()], 500);
        }
    }
}
