<?php

namespace App\Exports;

use App\Models\Admin\WorkingDays;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TimeSheetExport implements FromCollection, WithHeadings
{

  use Exportable;

  public function __construct(private string $month_id)
  {

  }

  public function headings(): array
  {
    return [
      'Empid',
      'Name',
      'Pay',
      'EmptyColumn',
      'Hours'
    ];
  }

  public function collection()
  {
    $result = [];

    $data = WorkingDays::with('user')
      ->where('month_id', $this->month_id)
      ->orderBy('user_id')
      ->get();

    foreach ($data as $item) {
      if($item->working_days == 0) continue;
      array_push($result, [
        'empid' => $item->user->empid,
        'name'  => $item->user->getFullEnglishNameAttribute,
        'pay'   => '1',
        'Empty' => '',
        'Hours' => ($item->working_days + $item->paid_days) * 8
      ]);
    }

    return collect($result);
  }
}
