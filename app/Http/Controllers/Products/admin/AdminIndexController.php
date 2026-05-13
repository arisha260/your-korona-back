<?php

namespace App\Http\Controllers\Products\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\AdminProductsResource;
use App\Services\adminProducts\ProductsService;
use Illuminate\Http\Request;

class AdminIndexController extends Controller
{
    public function __invoke(
        Request $request,
        ProductsService $productService)
    {
        $products = $productService->getProducts(
            perPage: $request->input('per_page', 20),
            page: $request->input('page', 1),
            categorySlug: $request->input('categorySlug', 'venki'),
            archiveFilter: (string)$request->input('archiveFilter', 'active'),
            search: $request->input('search')
        );

        return AdminProductsResource::collection($products)->additional([
            'nextPage' => $products->hasMorePages() ? $products->currentPage() + 1 : null,
            'total' => $products->total(),
        ]);
    }
}
