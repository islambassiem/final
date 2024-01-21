<?php

namespace App\Listeners;

use App\Events\FacultyCreated;
use App\Mail\Admin\FacultyCreated as AdminFacultyCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFacultyCreatedNotification
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
  public function handle(FacultyCreated $event): void
  {
    Mail::send(new AdminFacultyCreated($event->user));
  }
}