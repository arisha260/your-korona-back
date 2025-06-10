<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\KoronaNewMiniCardResource;
use App\Http\Resources\News\KoronaNewResource;
use App\Http\Resources\News\KoronaNewResourceLatest;
use App\Models\KoronaNew;
use App\Services\cache\NewsService;
use App\Services\news\NewsPaginateService;
use Illuminate\Http\Request;

class KoronaNewsController extends Controller
{

    protected $newsService;
    protected $newsPaginateService;

    public function __construct(NewsService $newsService, NewsPaginateService $newsPaginateService)
    {
        $this->newsService = $newsService;
        $this->newsPaginateService = $newsPaginateService;
    }

    public function index(Request $request)
    {

        $limit = 20;

        $news = $this->newsPaginateService->getNews($limit);

        return KoronaNewMiniCardResource::collection($news)->additional([
            'nextPage' => $news->hasMorePages() ? $news->currentPage() + 1 : null,
            'total' => $news->total(),
        ]);

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
