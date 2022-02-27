<?php

namespace App\Request;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    //
    protected $guarded = [];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved ($query)
    {
        return $query->where('status', 1);
    }

    public function scopeDeclined ($query)
    {
        return $query->where('status', 2);
    }

    public function scopeOn_Going ($query)
    {
        return $query->where('status', 0);
    }
}
