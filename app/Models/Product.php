<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
//    protected $guarded = false;
    protected $fillable = [
        'title',
        'description',
        'photos',
        'category_id',
        'actual_price',
        'old_price',
        'equipment',
        'external_links',
        'quantity',
        'views'
    ];

    protected $casts = [
        'photos' => 'array',
        'equipment' => 'array',
        'external_links' => 'array',
        'isNew' => 'boolean',
        'availability' => 'boolean',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
