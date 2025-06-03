<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
    ];


    protected static function booted()
    {
        static::creating(function ($material) {
            if (empty($new->slug)) {
                $baseSlug = Str::slug($material->name);
                $slug = $baseSlug;
                $i = 1;

                while (Material::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $i++;
                }

                $material->slug = $slug;
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
