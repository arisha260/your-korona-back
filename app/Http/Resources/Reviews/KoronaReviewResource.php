<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KoronaReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'description' => $this->description,
            'slug' => $this->slug,
            'author' => $this->author,
            'mark' => $this->mark,
//            'likes' => $this->likes,
            'product' => [
                'title' => $this->product->title,
                'slug' => $this->product->slug,
                'preview' => $this->product->preview,
            ],
            'created_at' => $this->created_label,
        ];
    }
}
