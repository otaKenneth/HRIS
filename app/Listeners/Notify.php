<?php

namespace App\Listeners;

use App\Events\LeaveRequest;
use App\Notifications\NewRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Notify implements ShouldQueue
{
    public function handle(LeaveRequest $event)
    {
        foreach ($event->notify as $key => $user) {
            $user->notify(new NewRequest($event->notification));
        }
    }
}
