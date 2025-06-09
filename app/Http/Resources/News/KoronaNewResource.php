<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KoronaNewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'img' => $this->img,
            'created_at' => $this->created_label,
            'is_updated' => $this->created_at,
            'updated_label' => $this->updated_label,
        ];
    }
}
