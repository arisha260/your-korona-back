<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'preview' => $this->preview,
            'actual_price' => $this->actual_price,
            'old_price' => $this->old_price,
            'isNew' => $this->is_new,
            'is_archived' => $this->is_archived,
            'created_relative' => $this->created_relative,
        ];
    }
}
