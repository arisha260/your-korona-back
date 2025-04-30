<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\ProductsResource;
use App\Models\CartItem;
use App\Models\Favorite;
use App\Models\KoronaNew;
use App\Models\Product;
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
            'subtotal' => $cartData['subtotal'] // Опционально
        ]);
    }
}
