<?php

namespace App\Policies;

use App\User;
use App\Models\Patient\PatientRecord;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientRecordPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any patient records.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // 
    }

    /**
     * Determine whether the user can view the patient record.
     *
     * @param  \App\User  $user
     * @param  \App\Patient\PatientRecord  $patientRecord
     * @return mixed
     */
    public function view(User $user, PatientRecord $patientRecord)
    {
        //
    }

    /**
     * Determine whether the user can create patient records.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the patient record.
     *
     * @param  \App\User  $user
     * @param  \App\Patient\PatientRecord  $patientRecord
     * @return mixed
     */
    public function update(User $user, PatientRecord $patientRecord)
    {
        return $user->admin || $user->super_admin;
    }

    /**
     * Determine whether the user can delete the patient record.
     *
     * @param  \App\User  $user
     * @param  \App\Patient\PatientRecord  $patientRecord
     * @return mixed
     */
    public function delete(User $user, PatientRecord $patientRecord)
    {
        //
    }

    /**
     * Determine whether the user can restore the patient record.
     *
     * @param  \App\User  $user
     * @param  \App\Patient\PatientRecord  $patientRecord
     * @return mixed
     */
    public function restore(User $user, PatientRecord $patientRecord)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the patient record.
     *
     * @param  \App\User  $user
     * @param  \App\Patient\PatientRecord  $patientRecord
     * @return mixed
     */
    public function forceDelete(User $user, PatientRecord $patientRecord)
    {
        //
    }
}
