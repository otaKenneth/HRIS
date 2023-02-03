<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;

class UsersSubNavigations extends Model
{
    protected $guarded = [];

    public function main_nav()
    {
        return $this->belongsTo(UsersNavigation::class);
    }
}
