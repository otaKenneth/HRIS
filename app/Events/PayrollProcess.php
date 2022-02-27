<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PayrollProcess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $to_processed;

    public function __construct($to_processed)
    {
        $this->to_processed = $to_processed;
    }
}
