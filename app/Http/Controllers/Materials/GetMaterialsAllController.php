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

        $perPage = $loadAll ? 1000 : 30;

        $materialsQuery = Material::latest();

        // Для оптимизации можно использовать fastPaginate
        $materials = $materialsQuery->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => MaterialsResource::collection($materials->items()),
            'total' => $materials->total(),
            'hasMore' => $materials->hasMorePages(),
        ]);
    }


}
