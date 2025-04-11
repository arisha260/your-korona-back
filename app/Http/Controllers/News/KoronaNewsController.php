<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\KoronaNewResource;
use App\Models\KoronaNew;

class KoronaNewsController extends Controller
{
    public function index() // /api/news
    {
        return KoronaNewResource::collection(KoronaNew::latest()->get());
    }

    public function latest() // /api/news/latest
    {
        return KoronaNewResource::collection(KoronaNew::latest()->take(4)->get());
    }

    public function show($id) // /api/news/{id}
    {
        $news = KoronaNew::findOrFail($id);
        return new KoronaNewResource($news);
    }
}
