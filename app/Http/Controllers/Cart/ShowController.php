<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Request $request, CartService $service){
        $cart = $service->getCartWithItems(
            $request->cookie('user_token')
        );

        return new CartResource($cart);
    }
}
