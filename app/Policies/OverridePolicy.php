<?php

namespace App\Policies;

use App\User;
use App\Models\Request\Override;
use Illuminate\Auth\Access\HandlesAuthorization;

class OverridePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any overrides.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->admin || $user->super_admin;
    }

    /**
     * Determine whether the user can view the override.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Override  $override
     * @return mixed
     */
    public function view(User $user, Override $override)
    {
        //
    }

    /**
     * Determine whether the user can create overrides.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the override.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Override  $override
     * @return mixed
     */
    public function update(User $user, Override $override)
    {
        //
    }

    /**
     * Determine whether the user can delete the override.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Override  $override
     * @return mixed
     */
    public function delete(User $user, Override $override)
    {
        //
    }

    /**
     * Determine whether the user can restore the override.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Override  $override
     * @return mixed
     */
    public function restore(User $user, Override $override)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the override.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Override  $override
     * @return mixed
     */
    public function forceDelete(User $user, Override $override)
    {
        //
    }
}
