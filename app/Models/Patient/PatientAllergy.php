<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientAllergy extends Model
{
    //
    protected $guarded = [];

    public function patient () {
        return $this->belongsTo(Patient::class);
    }
}
