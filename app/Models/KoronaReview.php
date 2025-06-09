<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoronaReview extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'slug', 'author', 'author_email', 'mark', 'img', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class)->select('id', 'title', 'slug', 'preview');
    }


    public function getCreatedLabelAttribute()
    {
        return $this->created_at->format('d.m.Y (H:i)');
    }

    public function getUpdatedLabelAttribute()
    {
        return $this->updated_at->format('d.m.Y (H:i)');
    }
}
