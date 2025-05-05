<?php

namespace App\Http\Resources;

use App\Models\Favorite;
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
                'data' => ProductsResource::collection($this['favorites']['data']),
                'total' => $this['favorites']['total']
            ],

        ];
    }
}
