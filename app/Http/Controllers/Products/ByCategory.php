<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\Request;

class ByCategory extends Controller
{
    public function __invoke(Request $request, $slug)
    {
        $perPage = $request->get('per_page', 20);

        $limit = 20;

        // Найти категорию по slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Найти продукты по category_id
        $products = Product::where('category_id', $category->id)->paginate($perPage);

        return ProductsResource::collection($products)->additional([
            'nextPage' => $products->count() < $limit ? null : $perPage + 1,
            'total' => $products->count(),
        ]);
    }

}
