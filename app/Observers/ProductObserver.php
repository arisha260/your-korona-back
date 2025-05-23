<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function created(Product $product): void
    {
        Cache::forget('popular_products');
    }


    public function updated(Product $product): void
    {
        Cache::forget('popular_products');
    }

    public function deleted(Product $product): void
    {
        Cache::forget('popular_products');
    }

    public function restored(Product $product): void
    {
        Cache::forget('popular_products');
    }

    public function forceDeleted(Product $product): void
    {

    }
}
