<?php

namespace App\Http\Controllers\Categories\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\admin\CategoryService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class AdminIndexController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke()
    {
        Gate::authorize('viewAny', Category::class);

        $categories = $this->categoryService->getAll();

        return CategoryResource::collection($categories);
    }
}
