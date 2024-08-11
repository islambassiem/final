<?php

namespace App\Mail\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeCard extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(public User $user)
  {
    //
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Employee ID Card',
      to: ['id@inaya.edu.sa'],
      cc: ['hr@inaya.edu.sa']
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.admin.UserRegistration.employeeCard',
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    return [];
  }
}
