<?php

namespace App\Console;

use App\Cronjobs\DocumentExpiryReminder;
use App\Cronjobs\IqamaRenewalList;
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
    $schedule->call(new IqamaRenewalList)->weeklyOn(0, '8:00');
    $schedule->call(new DocumentExpiryReminder)->dailyAt('05:00');
  }

  /**
   * Register the commands for the application.
   */
  protected function commands(): void
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
