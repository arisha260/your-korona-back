<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;


    public $order;


    public function __construct($order)
    {
        $this->order = $order;
    }


    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->markdown('mail.orderMail')  // Указываем ваш шаблон
        ->subject('Ваш заказ №' . $this->order->id . ' успешно оформлен!');
    }
}
