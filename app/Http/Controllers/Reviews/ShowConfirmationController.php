<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\ReviewFromConfirmationResource;
use App\Models\KoronaPendingReview;

class ShowConfirmationController extends Controller
{
    public function __invoke($slug){

        $review = KoronaPendingReview::where('slug', $slug)->firstOrFail();
        return new ReviewFromConfirmationResource($review);

    }
}
