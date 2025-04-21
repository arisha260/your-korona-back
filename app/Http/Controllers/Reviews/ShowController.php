<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\KoronaReview;
use App\Http\Resources\KoronaReviewResource;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke($slug)
    {
        $review = KoronaReview::where('slug', $slug)->firstOrFail();
        return new KoronaReviewResource($review);
    }
}
