<?php

namespace App\Http\Controllers;

use App\Imports\PayrollImport;
use App\Models\Admin\Month;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('payroll.index', [
            'month' => Month::where('month', date('n'))->where('year', date('Y'))->where('status', 1)->first()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => [
                'required',
                'file',
                'mimes:xlsx,xls',
            ],
        ]);

        $uploadedFile = $request->file('attachment');

        Excel::import(new PayrollImport, $uploadedFile);

        return redirect()->route('payroll.list')->with('success', 'Payroll converted successfully.');
    }

    public function list()
    {
        return view('payroll.list');
    }

    public function salaryCsv(Request $request)
    {
        $type = $request->query('type', 'all');

        $all = $this->salary(date('n'), date('Y'));

        $rows = match ($type) {
            'sponsored' => $this->sponsored($all),
            'cheques' => $this->cheques($all),
            'non' => $this->non($all),
            'all' => $all,
            default => abort(400, 'Invalid salary type.'),
        };

        $headers = [
            'Emp ID. No.',
            'Emp. Name',
            'ID Number',
            'Sponsorship',
            'Emp. Bank Code',
            'Emp. Acc. No.',
            'Salary Amount',
            'Basic Salary',
            'Housing Allowance',
            'Other Earnings',
            'Deduction',
        ];

        return response()->streamDownload(
            function () use ($rows, $headers) {

                while (ob_get_level() > 0) {
                    ob_end_clean();
                }

                $file = fopen('php://output', 'w');

                fputcsv($file, $headers);

                foreach ($rows as $row) {
                    fputcsv($file, [
                        $row['empid'],
                        $row['name'],
                        $row['national_id'],
                        $row['sponsorship'],
                        $row['bank_code'],
                        $row['iban'],
                        $row['finance'],
                        $row['basic'],
                        $row['housing'],
                        $row['Other Earnings'],
                        $row['Deduction'],
                    ]);
                }

                fclose($file);
            },
            "{$type}.csv",
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]
        );
    }

    private function salary($month, $year)
    {
        $sql = "
            WITH cte AS (
                select
                users.empid
                , salaries.basic
                , salaries.housing
                , salaries.transportation
                , salaries.food
                , salaries.effective
                , (salaries.basic + salaries.housing + salaries.transportation + salaries.food) as package
                , row_number() over(partition by empid order by effective desc) as rn
                , documents.document_id as national_id
                , if(users.sponsorship_id = 3 , 'Non-sponsored', 'Sponsored') as sponsorship
                , if(users.empid in (select empid from users where salary = 1 and sponsorship_id = 3 and nationality_id != 1), null, banks.iban) as iban
                , if(users.empid in (select empid from users where salary = 1 and sponsorship_id = 3 and nationality_id != 1), null, _banks.bank_code) as bank_code
                from users
                join salaries on salaries.user_id = users.id
                join documents on documents.user_id = users.id
                left join banks on banks.user_id = users.id
                left join _banks on _banks.id = banks.bank_code
                where documents.document_type_id = 1)
            select
                empid
                    , salary_diff.name
                    , basic
                    , housing
                    , round(IF( (finance - (basic + housing)) > 0 ,(finance - (basic + housing)) ,0 ), 0) AS 'Other Earnings'
                    , round(IF( (finance - (basic + housing)) < 0 , - (finance - (basic + housing)) ,0 ), 0) AS 'Deduction'
                    , national_id
                    , sponsorship
                    , iban
                    , bank_code
                    , round(salary_diff.finance,0) as finance
            from cte
            join salary_diff using(empid)
            where rn = ? and salary_diff.month = ? and salary_diff.year = ?;";

        return DB::select($sql, [1, $month, $year]);
    }

    private function cheques($array)
    {
        return collect($array)
            ->whereNull('iban')
            ->values()
            ->all();
    }

    private function non($array)
    {
        return collect($array)
            ->where('sponsorship', 'Non-sponsored')
            ->whereNotNull('iban')
            ->values()
            ->all();
    }

    private function sponsored($array)
    {
        return collect($array)
            ->where('sponsorship', 'Sponsored')
            ->whereNotNull('iban')
            ->values()
            ->all();
    }
}
