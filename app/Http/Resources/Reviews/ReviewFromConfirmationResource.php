<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewFromConfirmationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'slug' => $this->slug,
            'author' => $this->author,
            'author_email' => $this->author_email,
            'mark' => $this->mark,
            'product' => [
                'title' => $this->product->title,
                'slug' => $this->product->slug,
                'preview' => $this->product->preview,
            ],
            'created_label' => $this->created_label,
        ];
    }
}
