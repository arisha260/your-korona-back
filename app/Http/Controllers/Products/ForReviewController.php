<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductForReviewResource;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ForReviewController extends Controller
{
    public function __invoke($slug){


        $product = Product::where('slug', $slug)->firstOrFail();

        return new ProductForReviewResource($product);

    }
}
