<?php

namespace App\Mail;

use App\Models\User;
use App\Models\FamilyVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class FamilyVisitMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(public FamilyVisit $visit)
  {
    //
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    $user = User::find($this->visit->user_id);
    return new Envelope(
      subject: 'Family Visit Visa - زياره عائلية',
      to: 'idrisjaber@inaya.edu.sa',
      cc: ['hr@inaya.edu.sa', $user->email]
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.requests.family-visit',
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
