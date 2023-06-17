<?php

namespace App\Models\Payroll;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $guarded = [];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnprocessed ($query)
    {
        return $query->where("processed", false)->get();
    }

    public function scopeRanges ($query)
    {
        return $query->distinct()->select('range')->where("range_from", '<=', date('Y-m-d'))->orderBy('range_from', 'DESC')->get();
    }
}
