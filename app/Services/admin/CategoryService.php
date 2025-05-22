<?php

namespace App\Services\admin;

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
        Cache::forget('admin_categories_all');
        Cache::forget('categories_all');
    }
}
