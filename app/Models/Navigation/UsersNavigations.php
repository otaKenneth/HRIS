<?php

namespace App\Models\Navigation;

use App\Models\Navigation\UserNavigationsConnections as UNConnections;
use Illuminate\Database\Eloquent\Model;

class UsersNavigations extends Model
{
    protected $guarded = [];

    public function sub_navigations () {
        return $this->hasMany(UsersSubNavigations::class, 'main_nav_id', 'id');
    }

    /**
     * The user_nav_connections that belong to the UsersNavigations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user_nav_connections(): BelongsToMany
    {
        return $this->belongsToMany(UNConnections::class, 'user_navigations_connections', 'main_nav_id', 'id');
    }
}
