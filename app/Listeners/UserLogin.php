<?php

namespace App\Listeners;

use App\Events\DTRProcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLogin implements ShouldQueue
{
    public function handle(DTRProcess $event)
    {
        $event->user->inouts()->create([
            'type' => 0,
            'from' => 'webapp'
        ]);
    }
}
