<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;


    public $order;
    public string|null $customMessage;
    public function __construct(Order $order, ?string $customMessage = null)
    {
        $this->order = $order;
        $this->customMessage = $customMessage;
    }


    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->markdown('mail.order-status-updated')
            ->subject("Статус заказа №{$this->order->id} обновлён");
    }
}
