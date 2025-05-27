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

class AdminGetNewController extends Controller
{

    public function __invoke($slug)
    {

        $new = KoronaNew::where('slug', $slug)->firstOrFail();

        Gate::authorize('view', $new);

        return new KoronaNewResource($new);
    }

}
