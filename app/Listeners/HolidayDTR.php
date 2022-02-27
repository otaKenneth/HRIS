<?php

namespace App\Listeners;

use App\Events\CreateHolidayRecord;
use App\Http\Controllers\DailyTimeRecordController;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HolidayDTR implements ShouldQueue
{
    public function __construct()
    {
        $this->user = new User();
        $this->DTR = new DailyTimeRecordController();
    }

    public function handle(CreateHolidayRecord $event)
    {
        foreach ($this->user->get() as $user)
        {
            $this->DTR->process_holiday($user, $event->holiday);
        }
    }
}
