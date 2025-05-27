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
use Illuminate\Support\Facades\Storage;

class AdminDeleteNewController extends Controller
{

    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function __invoke($id)
    {

        $new = KoronaNew::findOrFail($id);

        Gate::authorize('delete', $new);

        if ($new->img &&
            $new->img !== KoronaNew::DEFAULT_IMG &&
            Storage::disk('yandex')->exists($new->img)) {
            Storage::disk('yandex')->delete($new->img);
        }

        $new->delete();

        $this->newsService->clearCache();

        return response()->json(['message' => 'Новость успешно удалена']);
    }

}
