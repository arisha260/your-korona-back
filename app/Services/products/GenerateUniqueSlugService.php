<?php

namespace App\Services\products;

use App\Models\KoronaReview;
use App\Models\Product;
use Illuminate\Support\Str;

class GenerateUniqueSlugService
{
    public function generateUniqueSlugFromTitle(string $title): string
    {
        $baseSlug = Str::slug($title) ?: 'product_img';
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}
