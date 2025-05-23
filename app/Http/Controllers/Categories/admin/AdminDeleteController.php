<?php

namespace App\Http\Controllers\Categories\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\cache\CategoryService;
use Illuminate\Support\Facades\Gate;

class AdminDeleteController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

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

        $this->categoryService->clearCache();

        return response()->json(['message' => 'Категория удалена']);
    }
}
