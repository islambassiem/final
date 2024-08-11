<?php

namespace App\Listeners;

use App\Events\EmployeeCreated;
use App\Mail\Admin\EmployeeCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmployeeCard
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
  public function handle(EmployeeCreated $event): void
  {
    Mail::queue(new EmployeeCard($event->user));
  }
}
