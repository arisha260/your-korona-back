<?php

namespace App\Http\Controllers\Categories\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\cache\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminTransferProductsController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request){

        Gate::authorize('delete', Category::class);

        $request->validate([
            'fromCategoryId' => 'required|exists:categories,id',
            'toCategoryId' => 'required|exists:categories,id|different:fromCategoryId',
        ]);

        Product::where('category_id', $request->fromCategoryId)
            ->update(['category_id' => $request->toCategoryId]);

        Category::findOrFail($request->fromCategoryId)->delete();

        $this->categoryService->clearCache();

        return response()->json(['message' => 'Товары перенесены, категория удалена']);
    }
}
