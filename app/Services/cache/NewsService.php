<?php

namespace App\Services\cache;

use App\Models\KoronaNew;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    public function getAll()
    {
        return Cache::remember('all_news', 60*60*24, function () {
            return KoronaNew::all();
        });
    }

    public function clearCache()
    {

        $keys = [
            'all_news',
            'latest_news',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
