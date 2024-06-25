<?php

namespace App\Exports;

use App\Models\Salary;
use App\Models\Admin\Month;
use App\Models\Admin\PayDeduct;
use App\Models\Admin\NonWorkingDays;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PayablesDeductExport implements FromCollection, WithHeadings
{

  use Exportable;
  /**
   * @return \Illuminate\Support\Collection
   */

  public function __construct(private string $month_id)
  {

  }

  public function headings(): array
  {
    return [
      'Empid',
      'Code',
      'Amount ',
      'Description'
    ];
  }
  public function collection()
  {
    $payaDeduct = PayDeduct::withWhereHas('user', function ($query){
      $query->where('salary', '1');
    })
    ->where('month_id', $this->month_id)
    ->orderBy('user_id')
    ->get();

    $payDeductArray = [];
    foreach ($payaDeduct as $item) {
      if($item->description == 'GOSI') continue;
      if($item->code == null){
        if($item->type == 0) $code = '1532';
        if($item->type == 1) $code = '1237';
      }else{
        $code = $item->code;
      }
      array_push($payDeductArray, [
        'empid'       => $item->user->empid,
        'code'        => $code,
        'amount'      => $item->amount,
        'Description' => $item->description
      ]);
    }

    $payDeductCollection = collect($payDeductArray);

    $annualVacation = NonWorkingDays::with(['user' => function ($query) {
      $query->where('salary', 1);
    }])
      ->where('month_id', $this->month_id)
      ->where('type', '1')
      ->get();

    $vacationsArray = [];

    foreach ($annualVacation as $item) {
      if(($item->user?->empid) == null) continue;
      array_push($vacationsArray, [
        'Empid'       => $item->user->empid,
        'code'        => '1235',
        'amount'      => number_format($item->days * str_replace("," , "" ,$this->salary($item->user->id, $this->endDate($this->month_id))) / 30, '2', '.', ''),
        'Description' => $item->days . ' days annual vacation ' . $item->user->empid
      ]);
    }

    $vacationCollection = collect($vacationsArray);

    $result = $vacationCollection->concat($payDeductCollection);

    return $result;
  }

  private function endDate($month_id)
  {
    return Month::find($month_id)->end_date;
  }


  private function salary($user_id, $end_date)
  {
    return Salary::where('user_id', $user_id)
      ->where('effective', '<=', $end_date)
      ->orderByDesc('effective')
      ->first()
      ->package();
  }


}
