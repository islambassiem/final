<?php

namespace App\Listeners;

use App\Events\FacultyResigned;
use App\Mail\Admin\FacultyResigned as AdminFacultyResigned;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFacultyResignedNotification
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(FacultyResigned $event): void
  {
    Mail::queue(new AdminFacultyResigned($event->user));
  }
}
