<?php

namespace App\Models\Navigation;

use App\User;
use App\Models\Navigation\UsersNavigations;
use App\Models\Navigation\UsersSubNavigations;

use Illuminate\Database\Eloquent\Model;

class UserNavigationsConnections extends Model
{
    protected $guarded = [];

    /**
     * Get the user that owns the UserNavigationsConnection
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function main_navigations()
    {
        return $this->hasOne(UsersNavigations::class, 'id', 'main_nav_id');
    }

    public function sub_navigations()
    {
        return $this->hasOne(UsersSubNavigations::class, 'id', 'sub_nav_id');
    }
}
