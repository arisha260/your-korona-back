<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KoronaNew extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'img',
    ];

    const DEFAULT_IMG = 'cover/news/news.png';

    public function setSlugAttribute($value)
    {
        // Если slug не передан, генерируем его из title
        if (!$value) {
            $this->attributes['slug'] = Str::slug($this->title);
        } else {
            $this->attributes['slug'] = $value;
        }
    }


    protected static function booted()
    {
        static::creating(function ($new) {
            if (empty($new->slug)) {
                $baseSlug = Str::slug($new->title);
                $slug = $baseSlug;
                $i = 1;

                while (KoronaNew::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $i++;
                }

                $new->slug = $slug;
            }
        });
    }

    public function getCreatedLabelAttribute()
    {
        return $this->created_at->format('d.m.Y (H:i)');
    }

    public function getIsUpdatedAttribute()
    {
        return $this->updated_at->ne($this->created_at);
    }


    public function getUpdatedLabelAttribute()
    {
        if ($this->updated_at->ne($this->created_at)) {
            return 'Обновлено: ' . $this->updated_at->format('d.m.Y H:i');
        }

        return null;
    }


    public function getShortDescriptionAttribute()
    {
        return strlen($this->description) > 100
            ? mb_substr($this->description, 0, 100) . '...'
            : $this->description;
    }

    public function getCreatedRelativeAttribute()
    {
        return Carbon::parse($this->created_at)
            ->locale('ru')
            ->diffForHumans();
    }
}
