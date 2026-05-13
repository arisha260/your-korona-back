<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class OrderUpdatedTelegramNotification extends Notification
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

        $message = "<b>Данные заказа №{$order->id}</b> обновлены\n";
        $message .= "<b>Клиент:</b> {$order->client_name}\n";
        $message .= "Телефон: {$order->client_tel}\n";
        $message .= "Почта: {$order->client_email}\n";
        $message .= "Город: {$order->client_city}\n";
        $message .= "Адрес: {$order->client_address}\n";
        $message .= "Индекс: {$order->client_index}\n\n";
        $message .= "Предпочтительный способ связи: {$order->client_social_type}\n";
        $message .= "Ссылка: {$order->client_social_url}\n\n";

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
