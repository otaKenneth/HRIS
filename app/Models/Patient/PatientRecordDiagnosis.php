<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientRecordDiagnosis extends Model
{
    //
    protected $guarded = [];

    public function record()
    {
        return $this->belongsTo(PatientRecord::class);
    }
}
