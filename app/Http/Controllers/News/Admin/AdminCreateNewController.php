<?php

namespace App\Http\Controllers\News\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KoronaNewsRequest;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\KoronaNewResourceLatest;
use App\Models\KoronaNew;
use App\Services\cache\NewsService;
use Illuminate\Support\Facades\Gate;

class AdminCreateNewController extends Controller
{

    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function __invoke(KoronaNewsRequest $request)
    {

        Gate::authorize('create');

        KoronaNew::create([
            'img' => 'images/news.png',
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $this->newsService->clearCache();

        return response()->json(['message' => 'Новость успешно создана']);

    }

}
