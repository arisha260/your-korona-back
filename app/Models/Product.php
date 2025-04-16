<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['is_new'];
//    protected $guarded = false;
    protected $fillable = [
        'title',
        'slug',
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

    public function getIsNewAttribute(): bool
    {
        return $this->created_at >= Carbon::now()->subDays(7);
    }

    public function setSlugAttribute($value)
    {
        // Если slug не передан, генерируем его из title
        if (!$value) {
            $this->attributes['slug'] = Str::slug($this->title);
        } else {
            $this->attributes['slug'] = $value;
        }
    }
}
