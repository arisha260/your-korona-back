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
        'views',
        'is_archived'
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

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function getMainPhotoAttribute(): ?string
    {
        return $this->photos[0] ?? null;
    }

    public function setExternalLinksAttribute($value)
    {
        $this->attributes['external_links'] = json_encode([
            'vk' => $value['vk'] ?? 'https://vk.com/aryosha',
            'telegram' => $value['telegram'] ?? 'https://t.me/aryossha',
        ]);
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->title);
                $slug = $baseSlug;
                $i = 1;

                while (Product::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $i++;
                }

                $product->slug = $slug;
            }
        });
    }

}
