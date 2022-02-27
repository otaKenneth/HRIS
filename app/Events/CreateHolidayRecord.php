<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateHolidayRecord
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $holiday;

    public function __construct($holiday)
    {
        return $this->holiday = $holiday;
    }
}
