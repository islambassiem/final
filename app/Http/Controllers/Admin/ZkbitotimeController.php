<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $raw = $request->getContent();

        Log::channel('zkdevice')->info('RAW REQUEST', [
            'payload' => $raw,
        ]);

        echo 'OK';
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        $lines = explode("\n", trim($raw));

        $insertData = [];
        $lastDeviceId = null;

        foreach ($lines as $line) {
            Log::channel('zkdevice')->info('DEVICE_PACKET', [
                'raw' => $line,
            ]);

            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // ===== DEVICE INFO =====
            if (strpos($line, '~DeviceName=') === 0) {

                $meta = $this->parseKeyValue($line);

                DB::table('zk_devices')->updateOrInsert(
                    ['ip' => $meta['IPAddress'] ?? null],
                    [
                        'name' => $meta['DeviceName'] ?? null,
                        'mac' => $meta['MAC'] ?? null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                $device = DB::table('zk_devices')->where('ip', $meta['IPAddress'] ?? null)->first();
                $lastDeviceId = $device->id ?? null;

                continue;
            }

            // ===== OPLOG SKIP =====
            if (strpos($line, 'OPLOG') === 0) {
                continue;
            }

            $parts = explode("\t", $line);

            if (\count($parts) >= 3 && is_numeric($parts[0]) && $time = date('Y-m-d H:i:s', strtotime($parts[1]))) {

                $insertData[] = [
                    'empid' => $parts[0],
                    'transaction' => $parts[1],
                    'device_id' => $lastDeviceId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                Log::channel('zkdevice')->info('ATTENDANCE', [
                    'empid' => $parts[0],
                    'datetime' => $parts[1],
                    'status' => $parts[2],
                    'device_id' => $lastDeviceId,
                ]);
            }
        }

        if (! empty($insertData)) {
            DB::table('zkbiotime')->insertOrIgnore($insertData);
            Log::channel('zkdevice')->info('ATTENDANCE_BATCH', [
                'count' => \count($insertData),
            ]);
        }
    }

    private function parseKeyValue($line)
    {
        // ~DeviceName=uFace800/ID,MAC=00:17:61:12:17:46,TransactionCount=94652,~MaxAttLogCount=10,UserCount=264,~MaxUserCount=100,PhotoFunOn=1,~MaxUserPhotoCount=2500,FingerFunOn=1,FPVersion=10,~MaxFingerCount=40,FPCount=285,FaceFunOn=1,FaceVersion=7,~MaxFaceCount=3000,FaceCount=227,FvFunOn=0,FvVersion=3,~MaxFvCount=10,FvCount=0,PvFunOn=0,PvVersion=5,~MaxPvCount=,PvCount=0,Language=69,IPAddress=10.1.1.17,~Platform=ZMM220_TFT,~OEMVendor=ZKTECO CO., LTD.,FWVersion=Ver 8.0.4.6-20221201,PushVersion=Ver 2.0.33S-20220623,RegDeviceType=,VisilightFun=,MultiBioDataSupport=,MultiBioPhotoSupport=,IRTempDetectionFunOn=,MaskDetectionFunOn=,UserPicURLFunOn=1,VisualIntercomFunOn=,VideoTID=,QRCodeDecryptFunList=,VideoProtocol=,IsSupportQRcode=,QRCodeEnable=,SubcontractingUpgradeFunOn=1
        $data = [];
        // Remove the starting "~"
        $line = ltrim($line, '~');
        // Split by commas
        $pairs = explode(',', $line);
        foreach ($pairs as $pair) {
            if (strpos($pair, '=') !== false) {
                [$key, $value] = explode('=', $pair, 2);

                $data[$key] = $value;
            }
        }

        return $data;
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
            MIN(z.transaction) AS checkin,
            MAX(z.transaction) AS checkout,
            CASE
                WHEN z.empid IS NULL AND v.user_id IS NOT NULL THEN 'vacation'
                WHEN z.empid IS NULL THEN 'absent'
                ELSE NULL
            END AS status,
            vt.vacation_type_ar,
            vt.vacation_type_en
        FROM dates d
        CROSS JOIN users u
        LEFT JOIN zkbiotime z ON z.empid = u.empid AND DATE(z.transaction) = d.date
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

                return [
                    'empid' => $row->empid,
                    'name_en' => $row->name_en,
                    'name_ar' => $row->name_ar,
                    'date' => $row->date,
                    'checkin' => $checkin,
                    'checkout' => $checkout,
                    'duration' => $duration,
                    'vacation' => $row->vacation_type_en !== null,
                    'absent' => $row->checkin === null && $row->checkout === null && $row->vacation_type_en === null,
                ];
            });
    }
}
