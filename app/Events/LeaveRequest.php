<?php

namespace App\Events;

use App\Notifications\NewRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LeaveRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public $notify;

    public function __construct($leave, $user, $admins = null)
    {
        if ($admins == null) {
            $from = date('M d, Y', strtotime($leave->from));
            $to = date('M d, Y', strtotime($leave->to));
            $status = ($leave->status == 1) ? "Approved" : "Declined";
            $link = "/Leave/$user->id?leave=$leave->id";
            
            $this->notification = [
                'id' => $leave->id,
                'type' => $leave->type . " Request",
                'by' => "$status By " . $user->lastname . " " . $user->firstname,
                'text' => "{$from} - {$to}",
                'link' => "$link",
            ];
        }else{
            $from = date('M d, Y', strtotime($leave->from));
            $to = date('M d, Y', strtotime($leave->to));
            $link = "/Leave?leave=$leave->id";
    
            $this->notification = [
                'id' => $leave->id,
                'type' => $leave->type . " Request",
                'by' => "{$user->lastname}, {$user->firstname}",
                'text' => "{$from} - {$to}",
                'link' => "$link",
            ];
        }

        foreach ($admins as $key => $admin) {
            $this->notify[] = $admin->user;
        }
    }
}
