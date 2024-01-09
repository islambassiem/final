<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;

class LeaveAction extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(public Leave $leave)
  {
    //
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    $user = $this->leave->user->email;
    $userName = $this->leave->user->name();
    $head = User::find($this->leave->user->head)->email;
    $headName = User::find($this->leave->user->head)->name();
    return new Envelope(
      from: new Address('noreply@csmonline.net', 'IMC - HRMS'),
      to: $user,
      subject: 'Leave Action',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.leave.action',
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
