<?php

namespace App\Policies;

use App\User;
use App\Models\Request\Overtime;
use Illuminate\Auth\Access\HandlesAuthorization;

class OvertimePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any overtimes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->admin || $user->super_admin;
    }

    /**
     * Determine whether the user can view the overtime.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Overtime  $overtime
     * @return mixed
     */
    public function view(User $user, Overtime $overtime)
    {
        //
    }

    /**
     * Determine whether the user can create overtimes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the overtime.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Overtime  $overtime
     * @return mixed
     */
    public function update(User $user, Overtime $overtime)
    {
        //
    }

    /**
     * Determine whether the user can delete the overtime.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Overtime  $overtime
     * @return mixed
     */
    public function delete(User $user, Overtime $overtime)
    {
        //
    }

    /**
     * Determine whether the user can restore the overtime.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Overtime  $overtime
     * @return mixed
     */
    public function restore(User $user, Overtime $overtime)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the overtime.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Overtime  $overtime
     * @return mixed
     */
    public function forceDelete(User $user, Overtime $overtime)
    {
        //
    }
}
