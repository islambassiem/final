<?php

namespace App\Http\Controllers\Head;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tables\VacationType;
use App\Models\Tables\WorkflowStatus;
use Carbon\Carbon;

class HeadVacationController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index(Request $request)
  {
    $sub = User::where('active', '1')->where('head', auth()->user()->id)->pluck('id')->toArray();
    $vacations = Vacation::with('user')
      ->when($request->start != null, function($q) use($request){
        $q->whereDate('end_date', '>=', Carbon::parse($request->start));
      }, function($q){
        $q->whereDate('end_date', '>=', Carbon::now());
      })
      ->when($request->end != null, function($q) use($request){
        $q->whereDate('start_date', '<=', Carbon::parse($request->end));
      }, function($q){
        $q->whereDate('start_date', '<=', Carbon::now());
      })
      ->when($request->type != null, function($q) use ($request){
        $q->where('vacation_type', $request->type);
      })
      ->when($request->status != null, function($q) use ($request){
        $q->where('status_id', $request->status);
      })
      ->get()
      ->whereIn('user_id', $sub);
    return view('head.vacations.index', [
      'vacations' => $vacations,
      'types' => VacationType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }
}
