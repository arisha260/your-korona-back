<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderUpdated extends Mailable
{
    use Queueable, SerializesModels;


    public $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->markdown('mail.order-updated')
            ->subject("Заказ №{$this->order->id} обновлён");
    }
}
