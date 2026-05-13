<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductsResource;
use App\Services\ProductService;

class PopularController extends Controller
{
    public function __invoke(ProductService $service){
        $popularProducts = $service->getPopular();
        return ProductsResource::collection($popularProducts);
    }
}
