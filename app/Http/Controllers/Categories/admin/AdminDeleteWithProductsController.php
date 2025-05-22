<?php

namespace App\Http\Controllers\Categories\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class AdminDeleteWithProductsController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request){

        Gate::authorize('delete', Category::class);

        $request->validate([
            'categoryId' => 'required|exists:categories,id',
        ]);

        $category = Category::findOrFail($request->categoryId);

        Product::where('category_id', $category->id)->delete();
        $category->delete();

        $this->categoryService->clearCache();

        return response()->json(['message' => 'Категория и её товары удалены']);
    }
}
