<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductsResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class FilteredByController extends Controller
{
    public function __invoke(Request $request, ProductService $productService)
    {
        $query = $request->input('q', '');

        return ProductsResource::collection($products)->additional([
            'nextPage' => $products->hasMorePages() ? $products->currentPage() + 1 : null,
            'total' => $products->total(),
        ]);
    }


}
