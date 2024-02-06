<?php

namespace App\Cronjobs;

use Carbon\Carbon;
use App\Models\Document;
use Illuminate\Support\Facades\Mail;


class IqamaRenewalList{
  public function __invoke()
  {
    $currentDate = Carbon::now();
    $expiryDateThreshold = $currentDate->addDays(30)->toDateString();
    $iqamas = Document::with(['user' => function($query){
        $query->with('sponsorship');
      }])
      ->whereHas('user', function($query){
        $query->where('active', '1')
          ->where('users.nationality_id', '>', '1')
          ->where('sponsorship_id', '!=', '3');
        })
      ->where('document_type_id', '1')
      ->whereDate('date_of_expiry', '<', $expiryDateThreshold)
      ->orderBy('date_of_expiry')
      ->get();
    if(count($iqamas) > 0){
      Mail::send(view: 'emails.admin.iqamaRenewalList', data: ['iqamas' => $iqamas] ,callback: function($message){
        $message->to('hr@inaya.edu.sa');
        $message->to('a.rashda@inaya.edu.sa');
        $message->to('yalzeer@inaya.edu.sa');
        $message->subject('الاقامات المنتهيه في خلال 30 يوم');
      });
    }
  }
}