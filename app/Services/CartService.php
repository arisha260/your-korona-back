<?php

namespace App\Services;

use App\Http\Resources\Products\ProductCardResource;
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

        return ['success' => true];
    }

    public function updateItem(string $userToken, int $productId, int $quantity): array
    {
        $cart = $this->getCart($userToken);

        $cart->items()
            ->where('product_id', $productId)
            ->update(['quantity' => $quantity]);

        return ['success' => true];
    }

    public function removeItem(string $userToken, int $productId): array
    {
        $cart = $this->getCart($userToken);
        $cart->items()->where('product_id', $productId)->delete();

        return ['success' => true];
    }

    public function clearCart(string $userToken): array
    {
        $cart = $this->getCart($userToken)->delete();

        return ['success' => true];
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

        return array_merge([
            'items' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product' => new ProductCardResource($item->product),
                    'quantity' => $item->quantity,
                    'price_total' => $item->product->actual_price * $item->quantity,
                ];
            }),
        ], $this->getCartSummary($cart));
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

    protected function calculateDiscount(Cart $cart): float
    {
        return $cart->items->sum(function ($item) {
            $old = $item->product->old_price;
            $actual = $item->product->actual_price;
            $quantity = $item->quantity;

            if ($old && $old > $actual) {
                return ($old - $actual) * $quantity;
            }

            return 0;
        });
    }


    protected function getCartSummary(Cart $cart): array
    {
        return [
            'total_items' => $cart->items()->sum('quantity'),
            'total_price' => $this->calculateTotalPrice($cart),
            'subtotal' => $this->calculateSubtotal($cart),
            'discount' => $this->calculateDiscount($cart),
        ];
    }

}
