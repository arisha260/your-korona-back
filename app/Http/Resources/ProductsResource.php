<?php

namespace App\Http\Resources;

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
            'description' => $this->description,
            'photos' => $this->photos,
            'category' => new CategoryResource($this->category),
            'actual_price' => $this->actual_price,
            'old_price' => $this->old_price,
            'equipment' => $this->equipment,
            'materials' => $this->materials,
            'external_links' => $this->external_links,
            'quantity' => $this->quantity,
            'views' => $this->views,
            'isNew' => $this->is_new,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
