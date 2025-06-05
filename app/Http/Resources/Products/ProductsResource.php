<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\CategoryResource;
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
//            'materials' => [
//                'id' => $this->materials->id,
//                'name' => $this->materials->name
//            ],
            'materials' => $this->materials->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name
                ];
            }),
            'external_links' => $this->external_links,
            'quantity' => $this->quantity,
            'views' => $this->views,
            'isNew' => $this->is_new,
            'is_archived' => $this->is_archived,
            'created_label' => $this->created_label,
            'updated_label' => $this->updated_label,
        ];
    }
}
