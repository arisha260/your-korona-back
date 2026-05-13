<?php

namespace App\Http\Controllers\Trackers;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\KoronaNewMiniCardResource;
use App\Http\Resources\News\KoronaNewResource;
use App\Http\Resources\News\KoronaNewResourceLatest;
use App\Models\KoronaNew;
use App\Models\Product;
use App\Services\cache\NewsService;
use App\Services\news\NewsPaginateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ProductViewController extends Controller
{
    public function track($id, Request $request)
    {
        // Валидация
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'ID продукта не найдено'], 400);
        }

        $userToken = $request->cookie('user_token');
        if (!$userToken) {
            return response()->json(['error' => 'User token required'], 403);
        }

        // Rate limiting по IP (60 запросов в минуту)
        $ipKey = 'product_view_ip:' . $request->ip();
        if (Redis::get($ipKey) > 60) {
            return response()->json(['error' => 'Слишком много запросов'], 429);
        }
        Redis::incr($ipKey);
        Redis::expire($ipKey, 3600);

        // Проверяем существование товара
        if (!Product::where('id', $id)->exists()) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }

        // Ключи для Redis
        $userViewKey = "product:user_view:{$id}:{$userToken}";
        $globalCounterKey = "product:views:{$id}";
        $dailyStatsKey = "product:views_stats:" . now()->format('Y-m-d');

        // Проверяем, был ли уже просмотр
        if (!Redis::exists($userViewKey)) {
            Redis::setex($userViewKey, 86400, true); // 24 часа
            Redis::hincrby($dailyStatsKey, $id, 1); // Статистика по дням
            Redis::incr($globalCounterKey); // Общий счетчик

            // Пакетное сохранение при достижении лимита
            if (Redis::get($globalCounterKey) % 100 === 0) {
                $this->syncToDatabase();
            }
        }

        return response()->json(['status' => 'ok']);
    }

    private function syncToDatabase()
    {
        // Используем Lua-скрипт для атомарной операции
        $script = <<<'LUA'
        local keys = redis.call('KEYS', 'product:views:*')
        local results = {}

        for _, key in ipairs(keys) do
            local id = string.match(key, 'product:views:(%d+)')
            local views = redis.call('GET', key)

            if id and views then
                table.insert(results, {id = id, views = views})
                redis.call('DEL', key)
            end
        end

        return results
        LUA;

        $data = Redis::eval($script, 0);

        foreach ($data as $item) {
            Product::where('id', $item['id'])
                ->increment('views', $item['views']);
        }
    }
}
