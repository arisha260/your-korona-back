<?php

namespace App\Http\Controllers\reviews;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\KoronaReviewCardResource;
use App\Services\reviews\ReviewsService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request, ReviewsService $reviewsService){

        $limit = 20;

        $reviews = $reviewsService->getReviews($limit);

        return KoronaReviewCardResource::collection($reviews)->additional([
            'nextPage' => $reviews->hasMorePages() ? $reviews->currentPage() + 1 : null,
            'total' => $reviews->total(),
        ]);

    }
}
