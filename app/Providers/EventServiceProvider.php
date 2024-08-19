<?php

namespace App\Providers;

use App\Events\FacultyCreated;
use App\Events\EmployeeCreated;
use App\Events\FacultyResigned;
use App\Events\EmployeeResigned;
use App\Listeners\SendEmployeeCard;
use App\Listeners\SendEmployeeToIt;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendEmployeeToFinance;
use App\Listeners\SendFacultyCreatedNotification;
use App\Listeners\SendFacultyResignedNotification;
use App\Listeners\SendEmployeeResignedNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event to listener mappings for the application.
   *
   * @var array<class-string, array<int, class-string>>
   */
  protected $listen = [
    Registered::class => [
      SendEmailVerificationNotification::class,
    ],

    FacultyCreated::class => [
      SendFacultyCreatedNotification::class
    ],

    EmployeeCreated::class => [
      SendEmployeeToFinance::class,
      SendEmployeeToIt::class,
      SendEmployeeCard::class,
    ],

    FacultyResigned::class => [
      SendFacultyResignedNotification::class
    ],

    EmployeeResigned::class => [
      SendEmployeeResignedNotification::class
    ],
  ];

  /**
   * Register any events for your application.
   */
  public function boot(): void
  {
    //
  }

  /**
   * Determine if events and listeners should be automatically discovered.
   */
  public function shouldDiscoverEvents(): bool
  {
    return false;
  }
}
