<?php

namespace App\Http\Controllers\Users\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\cache\AdminService;
use Illuminate\Support\Facades\Gate;

class AdminDeleteController extends Controller
{

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function __invoke($id)
    {
        $admin = User::findOrFail($id);

        if (auth()->id() === $admin->id) {
            abort(403, 'Нельзя удалить самого себя');
        }

        Gate::authorize('delete', $admin);

        $admin->delete();

        $this->adminService->clearCache();

        return response()->json(['message' => 'Админ удален']);
    }
}
