<?php

namespace App\Observers;

use App\Models\KoronaReview;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ReviewsObserver
{
    public function created(KoronaReview $review): void
    {
        Cache::forget('latest_reviews');
    }


    public function updated(KoronaReview $review): void
    {
        Cache::forget('latest_reviews');
    }

    public function deleted(KoronaReview $review): void
    {
        Cache::forget('latest_reviews');
    }

    public function restored(KoronaReview $review): void
    {
        Cache::forget('latest_reviews');
    }

    public function forceDeleted(Product $product): void
    {

    }
}
