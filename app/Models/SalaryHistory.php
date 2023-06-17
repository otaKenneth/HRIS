<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    protected $guarded = [];

    public function salary ()
    {
        return $this->belongsTo(Salary::class);
    }
}
