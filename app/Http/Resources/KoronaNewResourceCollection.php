<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class KoronaNewResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return KoronaNewResource::collection($this->collection);
    }

    public function with($request)
    {
        return [
            'total' => $this->collection->count(),
        ];
    }
}
