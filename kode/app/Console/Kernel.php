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
        // Run every 5 minutes to process scheduled posts and refresh tokens
        // (reduced from every minute to prevent memory exhaustion on Render free tier)
        $schedule->command('cron:run')
            ->everyFiveMinutes()
            ->withoutOverlapping(10) // max 10 min lock to prevent stuck processes
            ->runInBackground();
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
