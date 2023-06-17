<?php

namespace App\Models;

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
