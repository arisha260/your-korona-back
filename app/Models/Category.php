<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $baseSlug = Str::slug($category->name);
                $slug = $baseSlug;
                $i = 1;

                while (Category::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $i++;
                }

                $category->slug = $slug;
            }
        });
    }

}
