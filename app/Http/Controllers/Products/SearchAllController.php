<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\Request;

class SearchAllController extends Controller
{
    public function __invoke(Request $request){

        $query = $request->input('q');

        $products = Product::query()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q2) use ($query) {
                    $q2->where('title', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->get();

        $limited = $products->take(10);

        $rest = $products->slice(10)->values();

        return ProductsResource::collection($limited)->additional([
            'rest' => ProductsResource::collection($rest),
        ]);

    }
}
