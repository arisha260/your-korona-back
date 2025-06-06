<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'title' => $this->title,
            'actual_price' => $this->actual_price,
            'quantity' => $this->pivot->quantity,
            'preview' => $this->preview,
        ];
    }
}
