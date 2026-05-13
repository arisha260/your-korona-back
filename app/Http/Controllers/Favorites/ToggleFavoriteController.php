<?php

namespace App\Http\Controllers\Favorites;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class ToggleFavoriteController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->cookie('user_token');
        $productId = $request->input('product_id');

        if (!$productId) {
            return response()->json(['error' => 'Missing product_id'], 400);
        }

        $existing = Favorite::where('token', $token)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['removed' => true]);
        }

        Favorite::create([
            'token' => $token,
            'product_id' => $productId,
        ]);

        return response()->json(['added' => true]);
    }
}
