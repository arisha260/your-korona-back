<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\KoronaReview;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    public function getCart(string $userToken): Cart
    {
        return Cart::firstOrCreate(['user_token' => $userToken]);
    }

    public function addItem(string $userToken, int $productId, int $quantity = 1): CartItem
    {
        $cart = $this->getCart($userToken);

        return CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $productId
            ],
            [
                'quantity' => DB::raw("quantity + $quantity")
            ]
        )->load('product');
    }

    public function updateItem(string $userToken, int $productId, int $quantity): bool
    {
        return CartItem::whereHas('cart', fn($q) => $q->where('user_token', $userToken))
                ->where('product_id', $productId)
                ->update(['quantity' => $quantity]) > 0;
    }

    public function removeItem(string $userToken, int $productId): bool
    {
        return CartItem::whereHas('cart', fn($q) => $q->where('user_token', $userToken))
                ->where('product_id', $productId)
                ->delete() > 0;
    }

    public function clearCart(string $userToken): bool
    {
        return CartItem::whereHas('cart', fn($q) => $q->where('user_token', $userToken))
                ->delete() > 0;
    }

    public function getCartWithItems(string $userToken): Cart
    {
        return Cart::with(['items.product'])
            ->where('user_token', $userToken)
            ->firstOr(function () use ($userToken) {
                return $this->getCart($userToken);
            });
    }
}
