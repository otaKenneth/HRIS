<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InOut extends Model
{
    //
    protected $guarded = [];
    
    public function user() 
    {
        return $this->hasOne(User::class);
    }
}
