<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Zkbiotime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Zkbitotime extends Controller
{
    public function index()
    {
        return view('admin.fingerprint.index', [
            'users' => User::query()->where('active', 1)->where('fingerprint', 1)->get(),
        ]);
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
            'empid' => ['required', 'exists:users,empid'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $empid = $validated['empid'];
        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = Carbon::parse($validated['end_date'])->endOfDay();

        $result = Zkbiotime::query()
            ->where('empid', $empid)
            ->where('transaction', '>=', $startDate)
            ->where('transaction', '<=', $endDate)
            ->get();

        return $result;

    }
}
