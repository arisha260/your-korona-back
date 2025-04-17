<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getPopular($limit = 10)
    {
        return Product::orderByDesc('views')->take($limit)->get();
    }



    public function getNew($page = 1, $limit = 20, $maxTotal = 20)
    {

        $offset = ($page - 1) * $limit;

        if ($offset >= $maxTotal) {
            return collect();
        }

        $actualLimit = min($limit, $maxTotal - $offset);

        return Product::orderByDesc('created_at')
            ->orderByDesc('id')
            ->skip($offset)
            ->take($actualLimit)
            ->get();

    }
}
