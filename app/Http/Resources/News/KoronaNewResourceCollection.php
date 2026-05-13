<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Resources\Json\ResourceCollection;

class KoronaNewResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return KoronaNewMiniCardResource::collection($this->collection);
    }

    public function with($request)
    {
        return [
            'total' => $this->collection->count(),
        ];
    }
}
