<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KoronaReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product' => new ProductsResource($this->whenLoaded('product')),
            'description' => $this->description,
            'author' => $this->author,
            'mark' => $this->mark,
            'likes' => $this->likes,
            'img' => $this->img,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
