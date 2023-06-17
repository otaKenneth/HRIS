<?php

namespace App\Models\DailyTimeRecord;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyTimeRecord extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
