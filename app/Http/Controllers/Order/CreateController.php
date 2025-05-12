<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\ProductsResource;
use App\Mail\OrderCreated;
use App\Models\Favorite;
use App\Models\KoronaNew;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\NewOrderTelegramNotification;
use App\Services\tg\OrderTelegramFormatter;
use App\Services\tg\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CreateController extends Controller
{
    public function __invoke(Request $request, OrderRequest $orderRequest)
    {
        $token = $request->cookie('user_token');
        $products = $orderRequest->input('products'); // Массив товаров из корзины
        $totalQuantity = $orderRequest->input('total_quantity');
        $subtotalPrice = $orderRequest->input('subtotal');
        $totalPrice = $orderRequest->input('total_price');

        // Создаём заказ
        $order = Order::create([
            'client_name' => $orderRequest->input('client_name'),
            'client_tel' => $orderRequest->input('client_tel'),
            'client_email' => $orderRequest->input('client_email'),
            'client_city' => $orderRequest->input('client_city'),
            'client_address' => $orderRequest->input('client_address'),
            'client_index' => $orderRequest->input('client_index'),
            'client_comment' => $orderRequest->input('client_comment'),
            'client_token' => $token,

            'delivery_method' => $orderRequest->input('delivery_method'),
            'payment_method' => $orderRequest->input('payment_method'),

            'total_quantity' => $totalQuantity,
            'subtotal_price' => $subtotalPrice,
            'total_price' => $totalPrice,

            'status' => 'waiting',
        ]);

        // Привязываем товары к заказу
        foreach ($products as $item) {
            $order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
            ]);
        }


        Notification::route('telegram', config('services.telegram.chat_id'))
            ->notify(new NewOrderTelegramNotification($order));

        Mail::to($order->client_email)->send(new OrderCreated($order));

        return response()->json(['message' => 'Заказ успешно создан', 'order_id' => $order->id], 201);
    }
}
