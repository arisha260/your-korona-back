<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\KoronaNewResourceLatest;
use App\Models\KoronaNew;
use App\Services\cache\NewsService;

class KoronaNewsController extends Controller
{

    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {

        $news = $this->newsService->getAll();

        return new KoronaNewResourceCollection($news);

    }


    public function latest()
    {
        return KoronaNewResourceLatest::collection(KoronaNew::latest()->take(4)->get());
    }

    public function show($slug)
    {
        $news = KoronaNew::where('slug', $slug)->firstOrFail();
        return new KoronaNewResource($news);
    }

}
