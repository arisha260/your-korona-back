<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminIndexController extends Controller
{
    public function __invoke(){

        Gate::authorize('viewAny', Category::class);

        // Тут Redis не обязателен, но можно оставить
        $categories = Cache::remember('admin_categories_all', 300, function () {
            return Category::all();
        });

        return CategoryResource::collection($categories);
    }
}
