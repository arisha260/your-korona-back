<?php

namespace App\Services\reviews;

use App\Models\KoronaReview;

class ReviewsService
{
    public function getReviews($limit = 20)
    {
        return KoronaReview::with(['product' => function ($q) {
            $q->select('id', 'title', 'slug', 'preview');
        }])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($limit);

    }

}
