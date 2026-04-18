<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Zkbiotime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZkbitotimeController extends Controller
{
    public function index(Request $request)
    {
        $empid = $request->input('empid');

        $employee = $empid
            ? User::where('empid', $empid)->first()
            : null;

        $startDate = ($request->date('start_date') ?? Carbon::today())->startOfDay();
        $endDate = ($request->date('end_date') ?? Carbon::today())->endOfDay();
        $period = CarbonPeriod::create($startDate, $endDate);

        return view('admin.fingerprint.index', [
            'users' => User::query()->where('active', 1)->where('fingerprint', 1)->get(),
            'fingerprint' => $this->fingerprint($request, $startDate, $endDate),
            'empid' => $empid,
            'employee' => $employee,
            'period' => $period,
        ]);
    }

    protected function fingerprint(Request $request, Carbon $startDate, Carbon $endDate)
    {
        $empid = $request->input('empid');

        return Zkbiotime::query()
            ->select([
                'zkbiotime.empid',
                DB::raw("CONCAT_WS(' ', first_name_en, middle_name_en, third_name_en, family_name_en) AS name_en"),
                DB::raw("CONCAT_WS(' ', first_name_ar, middle_name_ar, third_name_ar, family_name_ar) AS name_ar"),
                DB::raw('DATE(transaction) AS date'),
                DB::raw('MIN(transaction) AS checkin'),
                DB::raw('MAX(transaction) AS checkout'),
            ])
            ->join('users', 'users.empid', '=', 'zkbiotime.empid')
            ->where('zkbiotime.empid', $empid)
            ->whereBetween('transaction', [
                $startDate->format('Y-m-d H:i:s'),
                $endDate->format('Y-m-d H:i:s'),
            ])
            ->groupBy('zkbiotime.empid', DB::raw('DATE(transaction)'))
            ->orderBy(DB::raw('DATE(transaction)'))
            ->get()
            ->keyBy('date');
    }
}
