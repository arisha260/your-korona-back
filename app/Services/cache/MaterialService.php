<?php

namespace App\Services\cache;

use App\Models\Material;
use Illuminate\Support\Facades\Cache;

class MaterialService
{
    public function getAll()
    {
        return Cache::remember('admin_materials_all', 300, function () {
            return Material::all();
        });
    }

    public function clearCache()
    {

        $keys = [
            'admin_materials_all',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
