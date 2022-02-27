<?php

namespace App\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientRecordExamination extends Model
{
    //
    protected $guarded = [];

    public function record()
    {
        return $this->belongsTo(PatientRecord::class);
    }
}
