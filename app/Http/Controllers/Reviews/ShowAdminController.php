<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\AdminReviewResource;
use App\Models\KoronaReview;

class ShowAdminController extends Controller
{
    public function __invoke($slug)
    {
        $review = KoronaReview::where('slug', $slug)->firstOrFail();
        return new AdminReviewResource($review);
    }
}
