<?php

namespace App\Http\Controllers\Categories\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\cache\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminAddCategoryController extends Controller
{

    protected $categoryService;

    public function __construct(Request $request,CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request){

        Gate::authorize('create', Category::class);

        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        $this->categoryService->clearCache();

        return response()->json(['message' => 'Добавлена новая категория']);
    }
}
