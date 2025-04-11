<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke($id){
        $product = Product::findOrFail($id);
        return new ProductsResource($product);
    }
}
