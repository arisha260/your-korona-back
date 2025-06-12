<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class NewOrderTelegramNotification extends Notification
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

//    public function toMail(object $notifiable): MailMessage
//    {
//        return (new MailMessage)
//            ->line('The introduction to the notification.')
//            ->action('Notification Action', url('/'))
//            ->line('Thank you for using our application!');
//    }

    public function toTelegram($notifiable)
    {
        $order = $this->order;

        $message = "🛒 <b>Новый заказ №{$order->id}</b>\n";
        $message .= "📦 Метод доставки: {$order->delivery_method_label}\n";
        $message .= "💳 Способ оплаты: {$order->payment_method_label}\n\n";
        $message .= "👤 <b>Клиент:</b> {$order->client_name}\n";
        $message .= "📞 Телефон: {$order->client_tel}\n";
        $message .= "✉️ Почта: {$order->client_email}\n\n";
        $message .= "✉️ Предпочтительный способ связи клиента: {$order->client_social_type}\n";
        $message .= "✉️ Ссылка: {$order->client_social_url}\n\n";

        foreach ($order->products as $product) {
            $message .= "      - {$product->title} × {$product->pivot->quantity} — {$product->actual_price}₽\n";
        }

        $message .= "\n💰 <b>Итого:</b> {$order->total_price} ₽\n";

        if (!empty($order->client_comment)) {
            $message .= "💬 Комментарий: {$order->client_comment}\n";
        }

        $message .= "📍 Статус: <b>{$order->status_label}</b>";

        return TelegramMessage::create()
            ->to(config('services.telegram.chat_id'))
            ->content($message)
            ->options(['parse_mode' => 'HTML']);
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
