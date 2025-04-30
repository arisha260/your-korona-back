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
        return Cart::firstOrCreate(['token' => $userToken]);
    }

    public function addItem(string $userToken, int $productId, int $quantity = 1): ?array
    {
        $cart = $this->getCart($userToken);

        $existingItem = $cart->items()->where('product_id', $productId)->first();

        if ($existingItem) {
            return null;
        }

        $item = $cart->items()->create([
            'product_id' => $productId,
            'quantity' => $quantity
        ]);

        return [
            'item' => $item->load('product'),
            'total_items' => $cart->items()->sum('quantity'),
            'total_price' => $this->calculateTotalPrice($cart)
        ];
    }

    public function updateItem(string $userToken, int $productId, int $quantity): array
    {
        $cart = $this->getCart($userToken);

        $cart->items()
            ->where('product_id', $productId)
            ->update(['quantity' => $quantity]);

        return [
            'success' => true,
            'total_items' => $cart->items()->sum('quantity'),
            'total_price' => $this->calculateTotalPrice($cart)
        ];
    }

    public function removeItem(string $userToken, int $productId): array
    {
        $cart = $this->getCart($userToken);
        $cart->items()->where('product_id', $productId)->delete();

        return [
            'success' => true,
            'total_items' => $cart->items()->sum('quantity'),
            'total_price' => $this->calculateTotalPrice($cart)
        ];
    }

    public function getCartWithItems(string $userToken): array
    {
        $cart = Cart::with(['items' => function($query) {
            $query->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')->with('product');
        }])->where('token', $userToken)
            ->firstOr(function () use ($userToken) {
                return $this->getCart($userToken);
            });

        return [
            'items' => $cart->items,
            'total_items' => $cart->items->sum('quantity'),
            'total_price' => $this->calculateTotalPrice($cart),
            'subtotal' => $this->calculateSubtotal($cart)
        ];
    }

    protected function calculateTotalPrice(Cart $cart): float
    {
        return $cart->items->sum(function ($item) {
            return $item->product->actual_price * $item->quantity;
        });
    }

    protected function calculateSubtotal(Cart $cart): float
    {
        return $cart->items->sum(function ($item) {
            return $item->product->old_price
                ? $item->product->old_price * $item->quantity
                : $item->product->actual_price * $item->quantity;
        });
    }
}
