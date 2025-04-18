<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\KoronaReview;
use App\Http\Resources\KoronaReviewResource;
use Illuminate\Http\Request;

class LatestController extends Controller
{
    public function __invoke(){
        return KoronaReviewResource::collection(KoronaReview::with('product')->latest()->take(4)->get()
        );
    }
}
