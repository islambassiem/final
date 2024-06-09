<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Month;
use Illuminate\Bus\Queueable;
use App\Models\Admin\PayDeduct;
use App\Classes\SalaryNetAmount;
use App\Models\Admin\WorkingDays;
use App\Models\Admin\NonWorkingDays;
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
    $wd = WorkingDays::where('month_id', '=', $this->month->id)->select(['user_id']);
    $nwd = NonWorkingDays::where('month_id', '=', $this->month->id)->select(['user_id']);
    $users = PayDeduct::with('user')
      ->select(['user_id'])
      ->where('month_id', '=', $this->month->id)
      ->union($wd)
      ->union($nwd)
      ->orderBy('user_id')
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
