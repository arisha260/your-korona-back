<?php

namespace App\Services\reviews;

use App\Models\KoronaPendingReview;
use App\Models\KoronaReview;

class ReviewsConfirmService
{
    public function getReviews($limit = 20)
    {
        return KoronaPendingReview::with(['product' => function ($q) {
            $q->select('id', 'title', 'slug', 'preview');
        }])
            ->orderByDesc('created_at')
            ->orderByDesc('product_id')
            ->paginate($limit);

    }

}
