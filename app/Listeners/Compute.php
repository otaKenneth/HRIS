<?php

namespace App\Listeners;

use App\Events\PayrollProcess;
use App\Http\Controllers\PayrollController;
use Illuminate\Contracts\Queue\ShouldQueue;

class Compute implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->Payroll = new PayrollController();
    }

    /**
     * Handle the event.
     *
     * @param  PayrollProcess  $event
     * @return void
     */
    public function handle(PayrollProcess $event)
    {  
        foreach ($event->to_processed as $key => $row) {
            $this->Payroll->process($row);
        }
    }
}
