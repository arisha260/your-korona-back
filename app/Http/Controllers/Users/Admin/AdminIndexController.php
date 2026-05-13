<?php

namespace App\Http\Controllers\Users\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminResource;
use App\Models\User;
use App\Services\cache\AdminService;
use Illuminate\Support\Facades\Gate;

class AdminIndexController extends Controller
{

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function __invoke()
    {
        Gate::authorize('viewAny', User::class);

        $admins = $this->adminService->getAll();

        return AdminResource::collection($admins);
    }
}
