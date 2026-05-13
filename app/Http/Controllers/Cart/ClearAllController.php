<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
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
