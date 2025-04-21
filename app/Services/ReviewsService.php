<?php

namespace App\Services;

use App\Models\KoronaReview;
use App\Models\Product;

class ReviewsService
{
    public function getReviews($limit = 20)
    {

//        return KoronaReview::orderByDesc('created_at')
//            ->orderByDesc('id')
//            ->paginate($limit);
        return KoronaReview::with(['product' => function ($q) {
            $q->select('id', 'title', 'slug', 'photos');
        }])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($limit);

    }

}
