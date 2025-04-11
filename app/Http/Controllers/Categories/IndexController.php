<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(){
        return CategoryResource::collection(Category::all());
    }
}
