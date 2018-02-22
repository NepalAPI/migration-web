<?php

namespace App\Console;

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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\PostMetadataUpdate::class,
        \App\Console\Commands\QuestionMetadataUpdate::class,
        \App\Console\Commands\AclSetup::class,
        \App\Console\Commands\FetchRssFeeds::class,
        \App\Console\Commands\SendPushNotifications::class,
        \App\Console\Commands\SendForexPushNotifications::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('nrna:fetchrss')
                 ->twiceDaily();

        $schedule->command('pushnotification:send')
                 ->everyFiveMinutes();

        $schedule->command('forexpushnotification:send')
                 ->everyMinute();
    }
}
