<?php

namespace App\Services;

use App\Mail\VacationApplication;
use App\Models\User;
use App\Models\Vacation;
use App\Models\VacationDetail;
use App\Notifications\ApplyVacation;
use App\Traits\VacationTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class StoreVacationService
{
  use VacationTrait;
  public function store(array $data)
  {
    $this->annual($data);
    return redirect()->route('vacations.history')->with('success', 'You have applied for a vacation successfully');
  }

  private function annual(array $data)
  {

      $head = User::find(User::find($data['user_id'])->head);
      $days = $this->days($data['start_date'], $data['end_date']);
      $balance = $this->balance($data['end_date']);

      if($balance <= 0){
        $this->createVacation([
          'user_id' => $data['user_id'],
          'vacation_type' => '4',
          'returner' => 0,
          'start_date' => $data['start_date'],
          'end_date' => $data['end_date'],
          'status_id' => $data['status_id'],
        ]);
        $latest = Vacation::latest('id')->first('id');
        $this->detail($data, $latest->id);
        $head->notify(new ApplyVacation($latest));
        Mail::queue(new VacationApplication($latest));
        return 0;
      }

      if($days > $balance){
        // divide the vacation into paid and unpaid
        $end_date = Carbon::parse($data['start_date']);
        $paidStartDate = $data['start_date'];
        $paidEndDate = $end_date->addDays($balance - 1);
        $unpaidStartDate = (Carbon::parse($paidEndDate)->addDay());
        $unpaidEndDate = $data['end_date'];

        // process the paid portion
        $this->createVacation([
          'user_id' => $data['user_id'],
          'vacation_type' => $data['vacation_type'],
          'returner' => 0,
          'start_date' => $paidStartDate,
          'end_date' => $paidEndDate,
          'status_id' => $data['status_id'],
        ]);
        $latest = Vacation::latest('id')->first('id');
        $this->detail($data, $latest->id);
        $head->notify(new ApplyVacation($latest));
        Mail::queue(new VacationApplication($latest));

        //process the unpaid portion
        $this->createVacation([
          'user_id' => $data['user_id'],
          'vacation_type' => '4',
          'returner' => 0,
          'start_date' => $unpaidStartDate,
          'end_date' => $unpaidEndDate,
          'status_id' => $data['status_id']
        ]);
        $latest = Vacation::latest('id')->first('id');
        $this->detail($data, $latest->id);
        $head->notify(new ApplyVacation($latest));
        Mail::queue(new VacationApplication($latest));
      }elseif($days <= $balance){
        Vacation::create($data);
        $latest = Vacation::latest('id')->first('id');
        $this->detail($data, $latest->id);

        $head->notify(new ApplyVacation($latest));
        Mail::queue(new VacationApplication($latest));
      }
  }

  private function createVacation($data)
    {
      Vacation::create([
        'user_id' => $data['user_id'],
        'vacation_type' => $data['vacation_type'],
        'returner' => 0,
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date'],
        'status_id' => $data['status_id']
      ]);
  }

  private function detail(array $data, $latest)
  {
    VacationDetail::create([
      'vacation_id' => $latest,
      'employee_notes' => $data['detail']['employee_notes'],
      'hr_notes' => $data['detail']['hr_notes'],
      'head_notes' => $data['detail']['head_notes'],
      'employee_time' => $data['detail']['employee_time'],
      'hr_time' => $data['detail']['hr_time'],
      'head_status' => $data['detail']['head_status'],
      'hr_status' => $data['detail']['hr_status']
    ]);
    }
}
