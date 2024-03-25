<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\TransportationDeduction;

class TransportationDeductionController extends Controller
{
  public function __construct()
  {
    return $this->middleware(['admin', 'auth']);
  }

  public function index()
  {
    return view('admin.salaries.transportation-deduction', [
      'deductions' => TransportationDeduction::with('user')->whereNull('to')->orderByDesc('from')->orderByDesc('created_at')->get(),
      'users' => User::where('gender_id', '2')->where('active', '1')->whereNotIn('category_id', ['7', '8'])->get()
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'user_id' => ['required'],
      'from' => ['required', 'date']
    ], [
      'user_id' => __('admin/salaries.nameReq'),
      'from' => __('admin/salaries.fromReq')
    ]);

    TransportationDeduction::create($validated);
    return redirect()->back()->with('success', __('admin/salaries.addDeductionSuccess'));
  }

  public function update(Request $request, string  $id)
  {
    $validated = $request->validate([
      'to' => 'required|date',
    ],[
      'to' => __('admin/salaries.toReq')
    ]);
    TransportationDeduction::where('id', $id)
      ->update([
        'to' => $validated['to']
      ]);
    return redirect()->back()->with('success', __('admin/salaries.delSuccess'));
  }
}
