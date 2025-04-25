<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    protected $fillable = ['token', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
