<?php

namespace App\Http\Controllers\TGBot;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }
    public function handle(Request $request)
    {
        try {
            $message = $request->input('message');
            Log::info('Incoming Telegram update: ' . json_encode($request->all()));

            if (!$message || !isset($message['text'])) return;

            $chatId = $message['chat']['id'];
            $text = $message['text'];

            if (str_starts_with($text, '/popular')) {
                $this->sendPopularProducts($chatId);
            }
        } catch (\Throwable $e) {
            Log::error('TelegramBotController error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }


    protected function sendPopularProducts($chatId)
    {
        // Логируем запрос к базе данных
        Log::info('Fetching popular products.');

        $products = Product::orderByDesc('views')->take(10)->get();

        // Логируем результат
        Log::info('Popular products: ', $products->toArray());

        if ($products->isEmpty()) {
            $this->sendMessage($chatId, "Популярные товары не найдены.");
            return;
        }

        $message = "🔥 Популярные товары:\n";
        foreach ($products->take(5) as $product) {
            $message .= "• {$product->title} — {$product->views} просмотров\n";
        }


        $this->sendMessage($chatId, $message);
    }


    protected function sendMessage($chatId, $text)
    {
        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }
}
