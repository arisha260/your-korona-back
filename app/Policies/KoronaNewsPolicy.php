<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\KoronaNew;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KoronaNewsPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::SuperAdmin;
    }

    public function view(User $user, KoronaNew $koronaNew): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::SuperAdmin;
    }


    public function create(User $user): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::SuperAdmin;
    }


    public function update(User $user, KoronaNew $koronaNew): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::SuperAdmin;
    }


    public function delete(User $user, KoronaNew $koronaNew): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::SuperAdmin;
    }


    public function restore(User $user, KoronaNew $koronaNew): bool
    {
        return false;
    }


    public function forceDelete(User $user, KoronaNew $koronaNew): bool
    {
        return false;
    }
}
