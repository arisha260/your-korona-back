<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class PopularController extends Controller
{
    public function __invoke(ProductService $service){
        $popularProducts = $service->getPopular();
        return ProductsResource::collection($popularProducts);
    }
}
