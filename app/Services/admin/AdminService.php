<?php

namespace App\Services\admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AdminService
{
    public function getAll()
    {
        return Cache::remember('all_admins', 60*60*24, function () {
            return User::all();
        });
    }

    public function clearCache()
    {

        $keys = [
            'all_admins',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
