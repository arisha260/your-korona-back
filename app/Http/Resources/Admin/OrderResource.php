<?php

namespace App\Http\Resources\Admin;

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
            'client_email' => $this->client_email,
            'client_city' => $this->client_city,
            'client_address' => $this->client_address,
            'client_index' => $this->client_index,
            'client_comment' => $this->client_comment,
            'delivery_method' => $this->delivery_method_label,
            'payment_method' => $this->payment_method_label,
            'status' => $this->status_label,
            'total_quantity' => $this->total_quantity,
            'subtotal_price' => $this->subtotal_price,
            'total_price' => $this->total_price,
            'created_label' => $this->created_label,
            'updated_label' => $this->updated_label,
            'products' => OrderProductResource::collection($this->products),
        ];
    }
}
