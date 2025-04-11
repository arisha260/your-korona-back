<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\KoronaReview;
use App\Http\Resources\KoronaReviewResource;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke($id){
        $review = KoronaReview::findOrFail($id);
        return new KoronaReviewResource($review);
    }
}
