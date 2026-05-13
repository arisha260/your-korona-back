<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductCardResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchAllController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q', '');
        $page = (int) $request->input('page', 1);
        $loadAll = $request->boolean('loadAll', false);

        // По умолчанию 10, если запрашиваем все — большое число
        $perPage = $loadAll ? 1000 : 10;

        $productsQuery = Product::active()

            ->when($query, function ($q) use ($query) {
                $q->where('title', 'ILIKE', '%' . trim($query) . '%');
            })
            ->latest();

        $total = $productsQuery->count();

        $products = $productsQuery
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'data' => ProductCardResource::collection($products),
            'total' => $total,
            'hasMore' => !$loadAll && ($page * $perPage) < $total,
        ]);
    }
}
