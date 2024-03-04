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
        Commands\TrimTempFolder::class,
        Commands\SetExpiryKelulusan::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('trim:tempfolder')->everyMinute()->onOneServer();
        $schedule->command('set:expirykelulusan')->everyMinute()->onOneServer();
        $schedule->command('set:expiryskb')->everyMinute()->onOneServer();
        $schedule->command('set:expirypengumuman')->everyMinute()->onOneServer();
        $schedule->command('set:bakibawaantabung')->everyMinute()->onOneServer();
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
