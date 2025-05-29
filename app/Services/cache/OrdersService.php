<?php

namespace App\Services\cache;

use App\Models\KoronaNew;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class OrdersService
{
    public function getAll()
    {
        return Cache::remember('all_orders', 60*60*24, function () {
            return Order::with('products')->get();
        });
    }

    public function clearCache()
    {

        $keys = [
            'all_orders',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
