<?php

namespace App\Listeners;

use App\Http\Controllers\DailyTimeRecordController as DTR;
use App\Events\DTRProcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Process implements ShouldQueue
{
    public function __construct()
    {
        $this->dtr = new DTR;
    }

    public function handle(DTRProcess $event)
    {
        $this->dtr->processPrevDate($event->user);
        $this->dtr->processMyDTR($event->user);
    }
}
