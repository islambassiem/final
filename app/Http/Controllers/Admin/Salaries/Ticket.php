<?php

namespace App\Http\Controllers\Admin\Salaries;

use App\Models\User;
use App\Models\Admin\PayDeduct;


trait Ticket
{
  public function tickets($date, $month_id)
  {
    $tickets = $this->totalTicketAllowance($date);
    foreach ($tickets as $user => $amount) {
      PayDeduct::insert([
        'user_id' => $user,
        'month_id' => $month_id,
        'amount' => $amount,
        'description' => 'Ticket Allowance ' . $date->format('m/Y'),
        'type' => '1',
        'code' => '1236',
        'created_at' => now(),
        'updated_at' => now()
      ]);
    }
  }

  private function totalTicketAllowance($date)
  {
    $ticket = $this->ticketAmount($date);
    $data = $this->dependentTicketAmount();
    $result = [];
    foreach ($ticket as $key => $value) {
      if(in_array($key, array_keys($data))){
        $result[$key] = round($value * $data[$key], 0) ;
      }else{
        $result[$key] = round($value,0);
      }
    }
    return $result;
  }

  private function ticketAmount($date)
  {
    $userTicket = User::whereHas('tickets')
    ->with('tickets')
    ->where('active', '1')
    ->get('id');

    foreach ($userTicket as $user) {
      $ticket[$user->id] = ($user->tickets->sortByDesc('effective')
        ->where('effective', '<=', $date)
        ->values()
        ->first())?->amount ?? 0;
    }

    return $ticket;
  }

  private function dependentTicketAmount()
  {
    $dependents = $this->dependents();
    foreach ($dependents as $dependent) {
      $data[$dependent[0]->user_id] = [];
      $tot = 0;
      foreach ($dependent as $item) {
        $tot += $item->ticketRate();
      }
      $data[$dependent[0]->user_id] = $tot + 1;
    }
    return $data;
  }

  private function dependents()
  {
    $users = User::whereHas('dependents', function($q){
        $q->where('ticket', '1');
      })
      ->with('dependents', function($q){
        $q->where('ticket', '1');
      })
      ->where('active', '1')
      ->get(['id']);

    foreach ($users as $user) {
      $dependents[$user->id] = $user->dependents;
    }
    return $dependents;
  }
}
