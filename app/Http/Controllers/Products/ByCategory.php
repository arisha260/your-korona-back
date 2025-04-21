<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ByCategory extends Controller
{
    public function __invoke(Request $request, $slug, ProductService $productService)
    {
        $limit = 20;
        $page = $request->input('page', 1);

        $products = $productService->getProductByCategory($slug, $limit, $page);

        return ProductsResource::collection($products)->additional([
            'nextPage' => $products->hasMorePages() ? $products->currentPage() + 1 : null,
            'total' => $products->total(),
        ]);
    }


}
