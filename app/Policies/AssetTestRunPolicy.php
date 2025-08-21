<?php

namespace App\Policies;

use App\Models\AssetTestRun;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetTestRunPolicy
{
    use HandlesAuthorization;

    protected function hasRole(User $user, array $roles): bool
    {
        return $user->groups()->whereIn('name', $roles)->exists();
    }

    public function viewAny(User $user): bool
    {
        return $this->hasRole($user, ['refurbisher', 'admin']);
    }

    public function view(User $user, AssetTestRun $run): bool
    {
        return $this->hasRole($user, ['refurbisher', 'admin']);
    }

    public function create(User $user): bool
    {
        return $this->hasRole($user, ['refurbisher', 'packer', 'supervisor', 'admin']);
    }

    public function update(User $user, AssetTestRun $run): bool
    {
        return $this->hasRole($user, ['refurbisher', 'packer', 'supervisor', 'admin']);
    }

    public function delete(User $user, AssetTestRun $run): bool
    {
        return $this->hasRole($user, ['admin']);
    }
}
