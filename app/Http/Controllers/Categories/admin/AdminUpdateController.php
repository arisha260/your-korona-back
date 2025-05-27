<?php

namespace App\Http\Controllers\Categories\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\cache\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminUpdateController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request, $id){


        Gate::authorize('update', Category::class);

        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        Category::findOrFail($id)->update([
            'name' => $request->name,
        ]);

        $this->categoryService->clearCache();

        return response()->json(['message' => 'Категория обновлена']);
    }
}
