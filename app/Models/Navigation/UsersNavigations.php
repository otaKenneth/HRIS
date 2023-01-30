<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;

class UsersNavigations extends Model
{
    protected $guarded = [];

    public function sub_navigations () {
        return $this->hasMany(UsersSubNavigations::class, 'main_nav_id', 'id');
    }
}
