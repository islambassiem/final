<?php

namespace App\Notifications;

use App\Models\Vacation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplyVacation extends Notification
{
  use Queueable;

  protected $vacation;

  /**
   * Create a new notification instance.
   */
  public function __construct(Vacation $vacation)
  {
    return $this->vacation = $vacation;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['database'];
  }

  /**
   * Get the mail representation of the notification.
   */
  // public function toMail(object $notifiable): MailMessage
  // {
  //   return (new MailMessage)
  //     ->line('The introduction to the notification.')
  //     ->action('Notification Action', url('/'))
  //     ->line('Thank you for using our application!');
  // }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  // public function toArray(object $notifiable): array
  // {
  //   return [
  //     //
  //   ];
  // }

  public function toDataBase($notifiable)
  {
    return [
      'id' => $this->vacation->id,
      'type' => 'Vacation',
      'title' => __('A new vacation has been requested'),
      'user' => auth()->user()->id
    ];
  }
}
