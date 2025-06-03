<?php

namespace App\Http\Controllers\Materials;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialsResource;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetMaterialsAllController extends Controller
{

//    protected $materials;
//
//    public function __construct(MaterialService $materials)
//    {
//        $this->materials = $materials;
//    }


    public function __invoke(Request $request)
    {

        Gate::authorize('viewAny', Material::class);

        $page = (int) $request->input('page', 1);
        $loadAll = $request->boolean('loadAll', false);

        $perPage = $loadAll ? 1000 : 10;

        $materialsQuery = Material::latest();

        $total = $materialsQuery->count();

        $materials = $materialsQuery
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'data' => MaterialsResource::collection($materials),
            'total' => $total,
            'hasMore' => !$loadAll && ($page * $perPage) < $total,
        ]);
    }


}
