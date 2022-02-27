<?php

namespace App\Providers;

use App\Events\CreateHolidayRecord;
use App\Events\DTRProcess;
use App\Events\LeaveRequest;
use App\Events\PayrollProcess;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        DTRProcess::class => [
            'App\Listeners\UserLogin',
            'App\Listeners\Process',
        ],
        PayrollProcess::class => [
            'App\Listeners\Compute',
        ],
        CreateHolidayRecord::class => [
            'App\Listeners\HolidayDTR',
        ],
        LeaveRequest::class => [
            'App\Listeners\Notify'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
