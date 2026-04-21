<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class ZkbitotimeController extends Controller
{
    public function index(Request $request)
    {
        $empid = $request->input('empid');

        $startDate = ($request->date('start_date') ?? Carbon::today())->startOfDay();
        $endDate = ($request->date('end_date') ?? Carbon::today())->endOfDay();

        return view('admin.fingerprint.index', [
            'users' => User::query()->where('active', 1)->where('fingerprint', 1)->get(),
            'fingerprint' => $this->fingerprint($request, $startDate, $endDate),
            'empid' => $empid,
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->input('data');

        if (! \is_array($payload) || empty($payload)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or empty data',
            ], 422);
        }

        $rows = [];
        $ids = [];
        $batchId = Str::uuid();

        foreach ($payload as $item) {
            if (! isset($item['id'], $item['emp_code'], $item['punch_time'])) {
                continue;
            }

            $rows[] = [
                'iclock_transaction_id' => $item['id'],
                'empid' => $item['emp_code'],
                'punch_time' => $item['punch_time'],
                'batch_uuid' => $batchId,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $ids[] = (int) $item['id'];
        }

        if (empty($rows)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No valid records',
            ], 422);
        }

        try {
            DB::beginTransaction();

            DB::table('zkbiotime')->insertOrIgnore($rows);
            $count = \count($rows);
            // 🔑 Find latest confirmed row from THIS batch
            $latest = DB::table('zkbiotime')
                ->where('batch_uuid', $batchId)
                ->orderByDesc('id')
                ->first();

            DB::commit();

            if (! $latest) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insert failed or no matching rows found',
                ], 500);
            }

            $matchedId = DB::table('zkbiotime')->orderByDesc('iclock_transaction_id')->first()->iclock_transaction_id;

            return response()->json([
                'status' => 'success',
                'last_id' => $matchedId,
                'synced_count' => $count,
                'last_row' => [
                    'empid' => $latest->empid,
                    'punch_time' => $latest->punch_time,
                ],
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function fingerprint(Request $request, Carbon $startDate, Carbon $endDate)
    {
        $empid = $request->input('empid');

        return collect(DB::select(
            "WITH RECURSIVE dates AS (
            SELECT DATE(?) AS date
            UNION ALL
            SELECT date + INTERVAL 1 DAY
            FROM dates
            WHERE date < ?
        ) SELECT
            u.empid,
            CONCAT_WS(' ', first_name_en, middle_name_en, third_name_en, family_name_en) AS name_en,
            CONCAT_WS(' ', first_name_ar, middle_name_ar, third_name_ar, family_name_ar) AS name_ar,
            d.date,
            MIN(z.punch_time) AS checkin,
            MAX(z.punch_time) AS checkout,
            CASE
                WHEN z.empid IS NULL AND v.user_id IS NOT NULL THEN 'vacation'
                WHEN z.empid IS NULL THEN 'absent'
                ELSE NULL
            END AS status,
            vt.vacation_type_ar,
            vt.vacation_type_en
        FROM dates d
        CROSS JOIN users u
        LEFT JOIN zkbiotime z ON z.empid = u.empid AND DATE(z.punch_time) = d.date
        LEFT JOIN vacations v on v.user_id = u.id AND d.date BETWEEN v.start_date AND v.end_date AND v.deleted_at IS NULL
        LEFT JOIN _vacation_types vt on vt.id = v.vacation_type
        WHERE u.empid = ?
        GROUP BY u.empid, d.date, v.vacation_type
        ORDER BY d.date
        ", [$startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $empid]))->map(function ($row) {

                $duration = null;
                $checkin = $row->checkin === null ? null : Carbon::parse($row->checkin)->format('H:i:s');
                $checkout = ($row->checkout === null || $row->checkin == $row->checkout) ? null : Carbon::parse($row->checkout)->format('H:i:s');

                if (Carbon::parse($row->checkin)->diffInSeconds(Carbon::parse($row->checkout)) == 0) {
                    $duration = ($row->checkin === null && $row->checkout === null && $row->vacation_type_en === null)
                        ? __('admin/fingerprint.absent')
                        : (session('_lang') == '_en' ? $row->vacation_type_en : $row->vacation_type_ar);
                } else {
                    $duration = Carbon::parse($row->checkin)->diffAsCarbonInterval(Carbon::parse($row->checkout));
                }

                if($this->isWeekend(Carbon::parse($row->date), $row->empid)){
                    $duration = __('admin/fingerprint.weekend');
                }

                Carbon::setLocale(app()->getLocale());
                return [
                    'empid' => $row->empid,
                    'name_en' => $row->name_en,
                    'name_ar' => $row->name_ar,
                    'date' => Carbon::parse($row->date)->translatedFormat('l j F Y'),
                    'checkin' => $checkin,
                    'checkout' => $checkout,
                    'duration' => $duration,
                    'isWeekend' => $this->isWeekend(Carbon::parse($row->date), $row->empid),
                    'vacation' => $row->vacation_type_en !== null,
                    'absent' => $row->checkin === null && $row->checkout === null && $row->vacation_type_en === null ,
                ];
            });
    }

    private function isWeekend(Carbon $date, string $empid): bool
    {
        if($date->dayOfWeek == 5){
            return true;
        }
        if($date->dayOfWeek == 6){
            return (bool)User::where('empid', $empid)->first()->saturday ? false : true;
        }
        return false;
    }
}
