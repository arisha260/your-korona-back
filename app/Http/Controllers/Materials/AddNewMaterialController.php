<?php

namespace App\Http\Controllers\Materials;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialsResource;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddNewMaterialController extends Controller
{

//    protected $materials;
//
//    public function __construct(MaterialService $materials)
//    {
//        $this->materials = $materials;
//    }


    public function __invoke(Request $request)
    {

        Gate::authorize('create', Material::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Material::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Добавлен новый материал']);
    }


}
