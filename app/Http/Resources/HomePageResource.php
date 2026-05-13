<?php

namespace App\Http\Resources;

use App\Http\Resources\News\KoronaNewCardResource;
use App\Http\Resources\Products\ProductCardResource;
use App\Http\Resources\Reviews\KoronaReviewCardResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'populars' => ProductCardResource::collection($this['populars']),
            'lastNews' => KoronaNewCardResource::collection($this['lastNews']),
            'latestReviews' => KoronaReviewCardResource::collection($this['latestReviews']),
            'newProducts' => [
                'data' => ProductCardResource::collection($this['newProducts']['data']),
                'nextPage' => $this['newProducts']['nextPage'],
                'hasNextPage' => $this['newProducts']['hasNextPage'],
                'total' => $this['newProducts']['total'],
            ],
            'categories' => CategoryResource::collection($this['categories']),
        ];
    }
}
