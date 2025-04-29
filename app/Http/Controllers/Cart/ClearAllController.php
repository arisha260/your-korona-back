<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class ClearAllController extends Controller
{
    public function __invoke(Request $request, CartService $service){
        $service->clearCart(
            $request->cookie('user_token')
        );

        return response()->json([
            'message' => 'Cart cleared'
        ]);
    }
}
