<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductCardResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ByCategory extends Controller
{
    public function __invoke(
        Request $request,
        string $slug,
        ProductService $productService
    ) {
        $products = $productService->getProductByCategory(
            slug: $slug,
            perPage: $request->input('per_page', 20),
            page: $request->input('page', 1),
            sort: $request->input('sort', 'newest'),
            search: $request->input('search')
        );

        return ProductCardResource::collection($products)->additional([
            'nextPage' => $products->hasMorePages() ? $products->currentPage() + 1 : null,
            'total' => $products->total(),
        ]);
    }
}
