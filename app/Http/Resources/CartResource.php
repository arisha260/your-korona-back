<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token,
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'title' => $item->product->title,
                    'price' => $item->product->actual_price,
                    'photo' => $item->product->photos[0] ?? null,
                ];
            }),
            'total' => $this->items->sum(function ($item) {
                return $item->quantity * $item->product->actual_price;
            }),
            'items_count' => $this->items->sum('quantity'),
        ];
    }
}
