<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Branch;
use Illuminate\Http\Request;
use App\Models\Admin\Holiday;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HolidayRequest;

class HolidayController extends Controller
{
  public function __construct()
  {
    return $this->middleware(['auth', 'admin']);
  }

  public function index()
  {
    return view('admin.holiday.index', [
      'branches' => Branch::all(),
      'holidays' => Holiday::orderBy('id', 'DESC')->get()
    ]);
  }

  public function store(HolidayRequest $request)
  {
    Holiday::create([
      'from' => $request->from,
      'to' => $request->to,
      'description' => $request->description,
      'branch_id' => $request->branch_id,
      'user_id' => auth()->user()->id
    ]);
    return redirect()->back()->with('success', __('admin/holiday.addedSuccess'));
  }
}
