<?php

namespace App\Models\Navigation;

use App\Models\Navigation\UsersSubNavigations as SubNavs;
use App\Models\Navigation\UserNavigationsConnections as UNConnections;
use Illuminate\Database\Eloquent\Model;

class UsersNavigations extends Model
{
    protected $guarded = [];

    public function sub_navigations () {
        return 
            $this->hasManyThrough(SubNavs::class, UNConnections::class, 'main_nav_id', 'id', 'id', 'sub_nav_id')
            ->groupBy('user_navigations_connections.sub_nav_id')
            ->with('sub_lvl_navigations');
    }

    public function user_nav_connections()
    {
        return $this->belongsToMany(UNConnections::class, 'user_navigations_connections', 'main_nav_id', 'id');
    }
}
