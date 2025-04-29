<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class AddController extends Controller
{
    public function __invoke(Request $request, CartService $service){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $item = $service->addItem(
            $request->cookie('user_token'),
            $request->input('product_id'),
            $request->input('quantity')
        );

        return response()->json([
            'message' => 'Товар добавлен в корзину',
            'item' => $item
        ]);
    }
}
