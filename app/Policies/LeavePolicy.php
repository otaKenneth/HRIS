<?php

namespace App\Policies;

use App\User;
use App\Models\Request\Leave;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeavePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any leaves.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->admin || $user->super_admin;
    }

    /**
     * Determine whether the user can view the leave.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Leave  $leave
     * @return mixed
     */
    public function view(User $user, Leave $leave)
    {
        // return $user->id == $leave->user_id;
    }

    /**
     * Determine whether the user can create leaves.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the leave.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Leave  $leave
     * @return mixed
     */
    public function update(User $user, Leave $leave)
    {
        //
    }

    /**
     * Determine whether the user can delete the leave.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Leave  $leave
     * @return mixed
     */
    public function delete(User $user, Leave $leave)
    {
        //
    }

    /**
     * Determine whether the user can restore the leave.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Leave  $leave
     * @return mixed
     */
    public function restore(User $user, Leave $leave)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the leave.
     *
     * @param  \App\User  $user
     * @param  \App\Request\Leave  $leave
     * @return mixed
     */
    public function forceDelete(User $user, Leave $leave)
    {
        //
    }
}
