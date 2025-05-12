<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __invoke(){
        try {
            $categories = Cache::remember('categories_all', 86400, function () {
                return Category::all();
            });

            return CategoryResource::collection($categories);
        } catch (\Exception $e) {
            Log::error('Failed to load categories in IndexController', ['error' => $e]);

            return response()->json([
                'message' => 'Failed to load categories'
            ], 500);
        }
    }
}
