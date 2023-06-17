<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    //
    protected $guarded = [];

    public function search($column, $search)
    {
        return $this->where('key', $column)->where('value', 'like', "%$search%")->first();
    }
}
