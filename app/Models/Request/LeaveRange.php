<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class LeaveRange extends Model
{
    //
    protected $guarded = [];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }

    public function scopeUsedLeave ($query)
    {
        return $query->where('pay', 1);

    }
}
