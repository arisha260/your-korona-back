<?php

namespace App\Http\Resources\Admin;

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
            'actual_price' => $this->actual_price,
            'old_price' => $this->old_price,
            'main_photo' => $this->main_photo,
            'isNew' => $this->is_new,
            'is_archived' => $this->is_archived,
            'created_at' => $this->created_at,
            'category_id' => $this->category_id,
        ];
    }
}
