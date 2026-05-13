<?php

namespace App\Services\cache;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DeleteProductService
{
    public function clearCache()
    {

        $keys = [
            'latest_reviews',
            'popular_products',

        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
