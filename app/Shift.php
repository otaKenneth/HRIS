<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    //

    protected $guarded = [];

    public function schedules () 
    {
        return $this->hasMany(Schedule::class);
    }
}
