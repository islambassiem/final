<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:60,1');
    }

    public function index($date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        }

        return response()->json([
            ...$this->inaya($date),
            // ...$this->shining($date),
        ]);

    }

    private function inaya($date)
    {
        $data = [];

        $inaya = $this->staff($date)
            ->where('category_id', '!=', 4)
            ->selectRaw('id, empid, email, full_name_en as name')
            ->get();

        foreach ($inaya as $user) {
            if ($this->attendable($date, 1)) {
                $data[] = $user;

            }
        }

        return $data;
    }

    private function shining($date)
    {
        $data = [];

        $shiing = $this->staff($date)
            ->where('category_id', '=', 4)
            ->selectRaw('id, empid, email, full_name_en as name')
            ->get();

        foreach ($shiing as $user) {
            if ($this->attendable($date, 2)) {
                $data[] = $user;

            }
        }

        return $data;
    }

    private function staff($date)
    {
        return User::query()
            ->whereDoesntHave('vacations', function ($query) use ($date) {
                $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
            })
            ->where('active', 1)
            ->where('joining_date', '<=', $date)
            ->where('fingerprint', 1)
            ->where('salary', 1);
    }

    private function holidays($branch)
    {
        return DB::table('holidays')
            ->where('branch_id', $branch)
            ->get();
    }

    private function saudis()
    {
        return User::query()
            ->where('active', 1)
            ->where('category_id', 8)
            ->selectRaw('id, empid, email, full_name_en as name')
            ->get();
    }

    private function attendable($date, $branch_id)
    {
        $day = date('l', strtotime($date));

        if ($branch_id == 2) {
            if (($day == 'Friday')) {
                return false;
            } else {
                $holidays = $this->holidays(2);
                foreach ($holidays as $holiday) {
                    if (($holiday->from <= $date && $holiday->to >= $date)) {
                        return false;
                    }
                }
            }

            return true;
        } else {
            if (($day == 'Friday' || $day == 'Saturday')) {
                return false;
            } else {
                $holidays = $this->holidays(1);
                foreach ($holidays as $holiday) {
                    if (($holiday->from <= $date && $holiday->to >= $date)) {
                        return false;
                    }
                }
            }

            return true;
        }
    }
}
