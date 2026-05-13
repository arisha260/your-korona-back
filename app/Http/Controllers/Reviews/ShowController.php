<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\KoronaReviewResource;
use App\Models\KoronaReview;

class ShowController extends Controller
{
    public function __invoke($slug)
    {
        $review = KoronaReview::where('slug', $slug)->firstOrFail();
        return new KoronaReviewResource($review);
    }
}
