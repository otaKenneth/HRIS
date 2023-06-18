<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLevelNavigations extends Model
{
    use HasFactory;

    protected $guarded = [];

    function sub_nav() {
        return $this->belongsTo(UsersSubNavigations::class);
    }
}
