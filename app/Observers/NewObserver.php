<?php

namespace App\Observers;

use App\Models\KoronaNew;
use App\Services\cache\NewsService;

class NewObserver
{

    public function created(KoronaNew $koronaNew): void
    {
        app(NewsService::class)->clearCache();
    }


    public function updated(KoronaNew $koronaNew): void
    {
        app(NewsService::class)->clearCache();
    }


    public function deleted(KoronaNew $koronaNew): void
    {
        app(NewsService::class)->clearCache();
    }


    public function restored(KoronaNew $koronaNew): void
    {
        //
    }


    public function forceDeleted(KoronaNew $koronaNew): void
    {
        //
    }
}
