<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    //
    protected $guarded = [];

    public function allergies () {
        return $this->hasMany(PatientAllergy::class);
    }

    public function hfds () {
        return $this->hasMany(PatientHeridoFamilialDisease::class);
    }

    public function records () {
        return $this->hasMany(PatientRecord::class)->orderBy('created_at', 'DESC');
    }

    public function patientNames () {
        return $this->select('id', DB::raw("CONCAT(lastname, ', ', firstname, ' ', middlename) as name"))->orderBy('lastname')->get();
    }

    public function gen () {
        return $this->hasOne('App\Lookup', 'id', 'gender');
    }
}
