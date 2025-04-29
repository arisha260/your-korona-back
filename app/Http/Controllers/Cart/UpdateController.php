<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request, CartService $service, int $productId){
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $service->updateItem(
            $request->cookie('user_token'),
            $productId,
            $validated['quantity']
        );

        return response()->json([
            'message' => 'Cart item updated'
        ]);
    }
}
