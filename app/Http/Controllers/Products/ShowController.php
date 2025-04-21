<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke($slug){

        $product = Product::where('slug', $slug)->firstOrFail();
        return new ProductsResource($product);

    }
}
