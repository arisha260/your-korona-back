<?php

namespace App\Http\Resources;

use App\Http\Resources\Products\ProductCardResource;
use App\Http\Resources\Products\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart' => $this['cart'],
            'favorites' => [
                'data' => ProductCardResource::collection($this['favorites']['data']),
                'total' => $this['favorites']['total']
            ],

        ];
    }
}
