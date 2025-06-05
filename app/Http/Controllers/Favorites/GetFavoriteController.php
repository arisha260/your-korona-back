<?php

namespace App\Http\Controllers\Favorites;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductsResource;
use App\Models\Favorite;
use Illuminate\Http\Request;

class GetFavoriteController extends Controller
{
    public function __invoke(Request $request)
    {
        $favorites = Favorite::where('token', $request->cookie('user_token'))
            ->with('product')
            ->get()
            ->pluck('product');

        return ProductsResource::collection($favorites)->additional([
            "total" => $favorites->count()
        ]);
    }
}
