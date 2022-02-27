<?php

namespace App\Policies;

use App\User;
use App\DailyTimeRecord;
use Illuminate\Auth\Access\HandlesAuthorization;

class DTRPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any daily time records.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->admin || $user->super_admin;
    }

    /**
     * Determine whether the user can view the daily time record.
     *
     * @param  \App\User  $user
     * @param  \App\DailyTimeRecord  $dailyTimeRecord
     * @return mixed
     */
    public function view(User $user, DailyTimeRecord $dailyTimeRecord)
    {
        // return $user->id === $user->id;
    }

    /**
     * Determine whether the user can create daily time records.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the daily time record.
     *
     * @param  \App\User  $user
     * @param  \App\DailyTimeRecord  $dailyTimeRecord
     * @return mixed
     */
    public function update(User $user, DailyTimeRecord $dailyTimeRecord)
    {
        //
    }

    /**
     * Determine whether the user can delete the daily time record.
     *
     * @param  \App\User  $user
     * @param  \App\DailyTimeRecord  $dailyTimeRecord
     * @return mixed
     */
    public function delete(User $user, DailyTimeRecord $dailyTimeRecord)
    {
        //
    }

    /**
     * Determine whether the user can restore the daily time record.
     *
     * @param  \App\User  $user
     * @param  \App\DailyTimeRecord  $dailyTimeRecord
     * @return mixed
     */
    public function restore(User $user, DailyTimeRecord $dailyTimeRecord)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the daily time record.
     *
     * @param  \App\User  $user
     * @param  \App\DailyTimeRecord  $dailyTimeRecord
     * @return mixed
     */
    public function forceDelete(User $user, DailyTimeRecord $dailyTimeRecord)
    {
        //
    }
}
