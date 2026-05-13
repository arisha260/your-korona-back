<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function __invoke(Request $request, CartService $service)
    {

        $cartData = $service->getCartWithItems($request->cookie('user_token'));

        return response()->json([
            'items' => $cartData['items'],
            'total_items' => $cartData['total_items'], // Общее количество товаров
            'total_price' => $cartData['total_price'], // Общая стоимость
            'subtotal' => $cartData['subtotal'], // Опционально
            'discount' => $cartData['discount'] // Скидка
        ]);
    }
}
