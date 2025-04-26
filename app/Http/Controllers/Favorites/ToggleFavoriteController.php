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
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class ToggleFavoriteController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->cookie('user_token') ?? (string) Str::uuid();
        $productId = $request->input('product_id');

        if (!$productId) {
            return response()->json(['error' => 'Missing product_id'], 400);
        }

        $existing = Favorite::where('token', $token)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()
                ->json(['removed' => true])
                ->withCookie(
                    new Cookie(
                        'user_token',
                        $token,
                        time() + 60 * 60 * 24 * 30, // вот здесь время жизни в UNIX timestamp!
                        '/',  // path
                        null, // domain
                        false, // secure
                        false, // httpOnly
                        false, // raw
                        'lax'  // sameSite
                    ));
        }

        Favorite::create([
            'token' => $token,
            'product_id' => $productId,
        ]);

        return response()
            ->json(['added' => true])
            ->withCookie(
                new Cookie(
                    'user_token',
                    $token,
                    time() + 60 * 60 * 24 * 30, // вот здесь время жизни в UNIX timestamp!
                    '/',  // path
                    null, // domain
                    false, // secure
                    false, // httpOnly
                    false, // raw
                    'lax'  // sameSite
                ));
    }
}
