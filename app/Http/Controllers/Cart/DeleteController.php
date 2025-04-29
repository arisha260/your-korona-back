<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(Request $request, CartService $service, int $productId){
        $service->removeItem(
            $request->cookie('user_token'),
            $productId
        );

        return response()->json([
            'message' => 'Product removed from cart'
        ]);
    }
}
