<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class AddController extends Controller
{
    public function __invoke(Request $request, CartService $service){

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $item = $service->addItem(
                $request->cookie('user_token'),
                $request->input('product_id'),
                $request->input('quantity')
            );

            if ($item === null) {
                return response()->json([
                    'message' => 'Товар уже находится в корзине',
                    'already_in_cart' => true
                ], 200);
            }

            return response()->json([
                'message' => 'Товар добавлен в корзину',
                'item' => $item
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при добавлении товара в корзину',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
