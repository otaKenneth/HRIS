<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //

    protected $guarded = [];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function shift ()
    {
        return $this->belongsTo(Shift::class);
    }
}
