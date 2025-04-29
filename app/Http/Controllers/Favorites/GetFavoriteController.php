<?php

namespace App\Http\Controllers\Favorites;

use App\Http\Controllers\Controller;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\ProductsResource;
use App\Models\Favorite;
use App\Models\KoronaNew;
use App\Models\Product;
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
