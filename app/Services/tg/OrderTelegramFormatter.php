<?php

namespace App\Services\tg;

use App\Models\KoronaReview;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderTelegramFormatter
{

    public static function format(Order $order): string
    {
        $message = "🛒 <b>Новый заказ</b>\n\n";
        $message .= "Номер заказа: {$order->id}\n\n";
        $message .= "Метод доставки: {$order->delivery_method_label}\n\n";
        $message .= "Способ оплаты: {$order->payment_method_label}\n\n";
        $message .= "Клиент: {$order->client_name}\n\n";
        $message .= "Телефон: {$order->client_tel}\n\n";
        $message .= "Почта: {$order->client_email}\n\n";
        $message .= "Товаров: {$order->total_quantity}\n\n";

        foreach ($order->products as $product) {
            $message .= "🔸 {$product->title} × {$product->pivot->quantity} — {$product->actual_price} ₽\n\n";
        }

        $message .= "Сумма: {$order->total_price} ₽\n\n";

        if (!empty($order->client_comment)) {
            $message .= "Комментарий: {$order->client_comment}\n\n";
        }

        $message .= "Статус: {$order->status}";

        return $message;
    }


}
