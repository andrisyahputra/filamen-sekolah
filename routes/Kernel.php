<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --tries=3')
            ->cron('* * * * *')
            ->withoutOverlapping(5)
            ->before(function () {
                Log::info('Queue worker started at: ' . now());
            })
            ->after(function () {
                Log::info('Queue worker completed at: ' . now());
            });
    }
}
