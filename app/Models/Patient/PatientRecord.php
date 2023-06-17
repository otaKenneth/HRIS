<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    //
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function examination()
    {
        return $this->hasOne(PatientRecordExamination::class);
    }

    public function hospitalizations()
    {
        return $this->hasMany(PatientHospitalization::class);
    }

    public function medications()
    {
        return $this->hasMany(PatientRecordMedication::class);
    }
    
    public function requests ()
    {
        return $this->hasMany(PatientRecordRequest::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(PatientRecordDiagnosis::class);
    }

    public function past_medications()
    {
        return $this->hasMany(PatientPastMedication::class);
    }
}
