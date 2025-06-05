<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminProductsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'photos' => $this->photos,
            'category' => new CategoryResource($this->category),
            'actual_price' => $this->actual_price,
            'old_price' => $this->old_price,
            'equipment' => $this->equipment,
            'materials' => $this->materials->pluck('id'),
            'external_links' => $this->external_links,
            'quantity' => $this->quantity,
            'views' => $this->views,
            'isNew' => $this->is_new,
            'is_archived' => $this->is_archived,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
