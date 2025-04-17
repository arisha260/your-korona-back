<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class LastNewController extends Controller
{
    public function __invoke(Request $request, ProductService $service){

        $page = $request->input('page', 1);
        $limit = 5;
        $maxTotal = 20;

        $products = $service->getNew($page, $limit, $maxTotal);

        return ProductsResource::collection($products)->additional([
            'nextPage' => $products->count() < $limit ? null : $page + 1,
            'total' => $maxTotal,
        ]);

    }

}
