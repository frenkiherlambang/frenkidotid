<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command(\Spatie\Health\Commands\RunHealthChecksCommand::class)->everyFiveMinutes();
        // $schedule->command('test-schedule')->everyMinute();
        // $schedule->command('capture')->hourly();
        // $schedule->command('delete-old-cctv-images')->hourlyAt(45);
        $schedule->command('fomo:getreview')->everyFiveMinutes();
        $schedule->command('check-galon')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
