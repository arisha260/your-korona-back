<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoronaReview extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'author', 'mark', 'img'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
