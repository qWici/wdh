<?php

namespace App\Console;

use App\Console\Commands\Streams\CheckStreamsOnline;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckStreamsOnline::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:streams')
            ->everyFifteenMinutes()
            ->appendOutputTo('/var/log/webdevhub.log');

        $schedule->command('check:articles')->hourly()->appendOutputTo('/var/log/webdevhub.log');
        $schedule->command('check:podcasts')->hourly()->appendOutputTo('/var/log/webdevhub.log');
        $schedule->command('check:videos')->hourly()->appendOutputTo('/var/log/webdevhub.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
