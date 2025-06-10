<?php

namespace App\Services\news;

use App\Models\KoronaNew;
use App\Models\KoronaReview;

class NewsPaginateService
{
    public function getNews($limit = 20)
    {
        return KoronaNew::orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($limit);

    }

}
