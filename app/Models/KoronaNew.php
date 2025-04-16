<?php

namespace App\Models;

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
