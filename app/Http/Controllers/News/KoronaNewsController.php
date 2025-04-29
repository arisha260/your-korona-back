<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\KoronaNewResourceLatest;
use App\Models\KoronaNew;

class KoronaNewsController extends Controller
{
    public function index()
    {

        $news = KoronaNew::latest()->get();

        return new KoronaNewResourceCollection($news);

    }


    public function latest() // /api/news/latest
    {
        return KoronaNewResourceLatest::collection(KoronaNew::latest()->take(4)->get());
    }

    public function show($slug)
    {
        $news = KoronaNew::where('slug', $slug)->firstOrFail();
        return new KoronaNewResource($news);
    }

}
