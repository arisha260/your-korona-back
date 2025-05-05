<?php

namespace App\Services;

use App\Http\Resources\ProductsResource;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\KoronaNew;
use App\Models\KoronaReview;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getData(Request $request, CartService $service): array
    {
        try {
            return [
                'cart' => $this->getCart($request, $service),
                'favorites' => $this->getFavorites($request),
            ];
        } catch (\Exception $e) {
            Log::error('User data failed', ['error' => $e]);
            throw $e;
        }
    }

    protected function getCart(Request $request, CartService $service): array
    {
        return $service->getCartWithItems($request->cookie('user_token'));
    }

    protected function getFavorites(Request $request): array
    {
        $favorites = Favorite::where('token', $request->cookie('user_token'))
            ->with('product')
            ->get()
            ->pluck('product');

        return [
            'data' => $favorites,
            'total' => $favorites->count()
        ];
    }

}
