<?php

namespace App\Http\Controllers\News\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\KoronaNewResource;
use App\Models\KoronaNew;
use Illuminate\Support\Facades\Gate;

class AdminGetNewController extends Controller
{

    public function __invoke($slug)
    {

        $new = KoronaNew::where('slug', $slug)->firstOrFail();

        Gate::authorize('view', $new);

        return new KoronaNewResource($new);
    }

}
