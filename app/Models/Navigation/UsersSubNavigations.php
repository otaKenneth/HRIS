<?php

namespace App\Models\Navigation;

use App\Models\Navigation\UserNavigationsConnections as UNConnections;
use Illuminate\Database\Eloquent\Model;

class UsersSubNavigations extends Model
{
    protected $guarded = [];

    public function main_nav()
    {
        return $this->belongsTo(UsersNavigation::class);
    }

    public function sub_lvl_navigations () {
        return $this->hasManyThrough(SubLevelNavigations::class, UNConnections::class, 'sub_nav_id', 'id', 'id', 'sub_lvl_nav_id');
    }

    function sub_lvl() {
        return $this->hasMany(SubLevelNavigations::class, 'sub_nav_id', 'id');
    }
}
