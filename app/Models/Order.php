<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_name',
        'client_tel',
        'client_email',
        'client_city',
        'client_address',
        'client_index',
        'client_comment',
        'client_token',
        'delivery_method',
        'payment_method',
        'status',
        'total_quantity',
        'subtotal_price',
        'total_price',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

}
