<?php

namespace App\Request;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Override extends Model
{
    //
    protected $guarded = [];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOn_Going ($query)
    {
        return $query->where('status', 0);
    }

    public function scopeApproved ($query)
    {
        return $query->where('status', 1);
    }

    public function scopeDeclined ($query)
    {
        return $query->where('status', 2);
    }

    public function scopeInout ($query)
    {
        return $query->where('override', 'inout');
    }

    public function scopeBreaks ($query)
    {
        return $query->where('override', 'breaks');
    }

    public function scopeIn ($query)
    {
        return $query->where('override', 'in');
    }

    public function scopeOut ($query)
    {
        return $query->where('override', 'out');
    }

    public function scopeBreakOut ($query)
    {
        return $query->where('override', 'breakOut');
    }

    public function scopeBreakIn ($query)
    {
        return $query->where('override', 'breakIn');
    }
}
