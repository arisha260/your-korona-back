<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'populars' => ProductsResource::collection($this['populars']),
            'lastNews' => KoronaNewResourceLatest::collection($this['lastNews']),
            'latestReviews' => KoronaReviewResourceLatest::collection($this['latestReviews']),
            'newProducts' => [
                'data' => ProductsResource::collection($this['newProducts']['data']),
                'nextPage' => $this['newProducts']['nextPage'],
                'total' => $this['newProducts']['total'],
            ],
            'categories' => CategoryResource::collection($this['categories']),
        ];
    }
}
