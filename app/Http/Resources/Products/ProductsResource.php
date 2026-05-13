<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'actual_price' => $this->actual_price,
            'old_price' => $this->old_price,
            'preview' => $this->preview,
            'isNew' => $this->is_new,
            'created_at' => $this->created_at,
            'category_id' => $this->category_id,
        ];
    }
}
