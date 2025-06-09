<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\KoronaReviewCardResource;
use App\Models\KoronaReview;

class LatestController extends Controller
{
    public function __invoke(){
        $products = KoronaReview::latest()->take(4)->get();
        return KoronaReviewCardResource::collection($products);
    }
}
