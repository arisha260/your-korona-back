<?php

namespace App\Services\tg;

use App\Models\KoronaReview;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{

    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    public function sendMessage(string $message): void
    {
        $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);

        if ($response->failed()) {
            Log::error('Ошибка отправки сообщения в Telegram', [
                'response' => $response->body(),
                'status_code' => $response->status(),
            ]);
        } else {
            Log::info('Сообщение отправлено в Telegram', ['message' => $message]);
        }
    }


}
