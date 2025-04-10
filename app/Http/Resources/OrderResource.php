<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client_name' => $this->client_name,
            'client_tel' => $this->client_tel,
            'client_address' => $this->client_address,
            'client_comment' => $this->client_comment,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products' => OrderProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
