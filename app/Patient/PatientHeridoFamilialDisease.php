<?php

namespace App\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientHeridoFamilialDisease extends Model
{
    //
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
