<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getPopular($limit = 10)
    {
        return Product::orderByDesc('views')->take($limit)->get();
    }
}
