<?php

namespace App\Mail;

use App\Models\User;
use App\Models\ExitReentry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExitReentryMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(public ExitReentry $visa)
  {
    //
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    $user = User::find($this->visa->user_id);
    return new Envelope(
      subject: 'Exit Reentry Request',
      to: 'hr@inaya.edu.sa',
      cc: $user->email
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.requests.exit-reentry',
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
