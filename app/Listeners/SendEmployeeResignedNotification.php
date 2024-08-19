<?php

namespace App\Listeners;

use App\Events\EmployeeResigned;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Admin\EmployeeResigned as AdminEmployeeResigned;

class SendEmployeeResignedNotification
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
  public function handle(EmployeeResigned $event): void
  {
    Mail::queue(new AdminEmployeeResigned($event->user));
  }
}
