<?php

namespace App\Http\Controllers\reviews;

use App\Http\Controllers\Controller;
use App\Models\KoronaReview;
use App\Http\Resources\KoronaReviewResource;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(){
        return KoronaReviewResource::collection(KoronaReview::all());
    }
}
