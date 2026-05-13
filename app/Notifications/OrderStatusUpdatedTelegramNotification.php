<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class OrderStatusUpdatedTelegramNotification extends Notification
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

    public function toTelegram($notifiable)
    {
        $order = $this->order;

        return TelegramMessage::create()
            ->to(config('services.telegram.chat_id'))
            ->content("✅ Статус заказа #{$order->id} обновлён: <b>{$order->status_label}</b>")
            ->options(['parse_mode' => 'HTML']);
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
