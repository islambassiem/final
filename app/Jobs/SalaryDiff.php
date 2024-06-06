<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Month;
use Illuminate\Bus\Queueable;
use App\Classes\SalaryNetAmount;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Admin\SalaryDiff as SalaryDiffModel;

class SalaryDiff implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public function __construct(public Month $month)
  {

  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $date = Carbon::create($this->month->year, $this->month->month)->endofMonth();
    $users = User::where('active', '1')
      ->where('salary', '1')
      ->where('joining_date', '<=', $date)
      ->get();
    $netAmount = new SalaryNetAmount;
    foreach ($users as $user) {
      SalaryDiffModel::create([
        'empid' => $user->empid,
        'month' => $this->month->month,
        'year'  => $this->month->year,
        'hr'    => $netAmount->index($user->id, $this->month->month, $this->month->year)
      ]);
    }
  }
}
