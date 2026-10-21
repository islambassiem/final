<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayrollImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row['emp_id_no'] === null) {
                continue;
            }
            $this->update($row);
        }
    }

    private function update($row)
    {
        DB::table('salary_diff')
            ->where('empid', $row['emp_name'])
            ->where('month', date('n'))
            ->where('year', date('Y'))
            ->update([
                    'name' => $row['emp_name'],
                    'finance' => $row['salary_amount'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'empid' => $row['emp_id_no'],
                    'month' => date('n'),
                    'year' => date('Y'),
                ]);

    }
}
