<?php

namespace App\Cronjobs;

use Carbon\Carbon;
use App\Models\Document;
use Illuminate\Support\Facades\Mail;


class DocumentExpiryReminder{
  public function __invoke()
  {
    $documents = Document::with('user:id,email')
    ->whereHas('user', function($query){
      $query->where('active', '1');
    })
    ->whereNot('date_of_expiry', 'IS NOT NULL', NULL)
    ->orderBy('date_of_expiry')
    ->get();
    foreach ($documents as $document) {
      $diff =  Carbon::parse($document->date_of_expiry)->diffInDays(Carbon::now());
      if($diff == $document->notification){
        Mail::send('emails.notification.documentExpiry', ['description' => $document->description ,'expiry' => date('d/m/Y', strtotime($document->date_of_expiry))], function($message) use($document){
          $message->to($document->user->email);
          $message->bcc('islambassiem@inaya.edu.sa');
          $message->subject('Document Expiry Reminder');
        });
      }
    }
  }
}