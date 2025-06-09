<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\KoronaReviewResource;
use App\Services\reviews\ReviewsConfirmService;
use Illuminate\Http\Request;

class IndexConfirmationController extends Controller
{
    public function __invoke(Request $request, ReviewsConfirmService $reviewsService){

        $limit = 20;

        $reviews = $reviewsService->getReviews($limit);

        return KoronaReviewResource::collection($reviews)->additional([
            'nextPage' => $reviews->hasMorePages() ? $reviews->currentPage() + 1 : null,
            'total' => $reviews->total(),
        ]);

    }
}
