<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminDeleteController extends Controller
{
    public function __invoke($id){

        $category = Category::withCount('products')->findOrFail($id);
        Gate::authorize('delete', $category);

        if ($category->products_count > 0) {
            $otherCategories = Category::where('id', '!=', $category->id)->get();

            return response()->json([
                'message' => 'У категории есть связанные товары',
                'code' => 'HAS_PRODUCTS',
                'categories' => $otherCategories,
            ], 409); // 409 Conflict — идеален тут
        }

        $category->delete();

        return response()->json(['message' => 'Категория удалена']);
    }
}
