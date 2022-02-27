<?php

namespace App\Request;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leave extends Model
{
    //
    protected $guarded = [];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function userName()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', DB::raw("CONCAT(lastname, ', ', firstname, ' ', middlename) as name"));
    }

    public function leaveRanges ()
    {
        return $this->hasMany(LeaveRange::class);
    }

    public function leaveOnStatus ($status)
    {
        return $this->where('status', $status)->orderBy('created_at', 'DESC');
    }

    public function scopeApproved ($query)
    {
        return $query->where('status', 1);
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 2);
    }
    
    public function scopeOn_Going($query)
    {
        return $query->where('status', 0);
    }
    
    public function scopeOn_Going_Sick($query)
    {
        return $query->where('type', 'SL')->where('status', 0);
    }
    
    public function scopeOn_Going_Vacation($query)
    {
        return $query->where('type', 'VL')->where('status', 0);
    }

    public function scopeApproved_Sick ($query) 
    {
        return $query->where('type', 'SL')->where('status', 1);
    }

    public function scopeDeclined_Sick ($query)
    {
        return $query->where('type', 'SL')->where('status', 2);
    }

    public function scopeApproved_Vacation ($query)
    {
        return $query->where('type', 'VL')->where('status', 1);
    }

    public function scopeDeclined_Vacation($query)
    {
        return $query->where('type', 'VL')->where('status', 2);
    }
}
