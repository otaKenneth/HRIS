<?php

namespace App\Payroll;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function scopePayroll ($query) 
    {
        return $query->where('key', 'like', "%payroll.%");
    }

    public function scopeSHComputation ($query)
    {
        return $query->where('key', 'like', "payroll.sh%");
    }

    public function scopeRHComputation($query)
    {
        return $query->where('key', 'like', "payroll.rh%");
    }

    public function scopeOTComputation($query)
    {
        return $query->where('key', 'like', "payroll.ot%");
    }
}
