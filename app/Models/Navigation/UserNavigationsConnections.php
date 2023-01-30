<?php

namespace App\Models\Navigation;

use App\User;
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
}
