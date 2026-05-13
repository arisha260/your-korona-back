<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request){
        $perPage = $request->get('per_page', 20);
        $products = Product::active()->paginate($perPage);
        return ProductResource::collection($products);
    }
}
