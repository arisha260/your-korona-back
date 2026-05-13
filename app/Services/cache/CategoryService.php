<?php

namespace App\Services\cache;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    public function getAll()
    {
        return Cache::remember('admin_categories_all', 300, function () {
            return Category::all();
        });
    }

    public function clearCache()
    {

        $keys = [
            'admin_categories_all',
            'categories_all',
            'popular_products',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
