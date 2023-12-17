<?php

namespace App\Http\Controllers\Head;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tables\WorkflowStatus;

class HeadPermissionController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index(Request $request)
  {
    $sub = User::where('active', '1')->where('head', auth()->user()->id)->pluck('id')->toArray();
    $q = Permission::with('user')
      ->when($request->start != null, function($q) use ($request) {
        return $q->whereDate('date', '>=', Carbon::parse($request->start));
      }, function($q){
        return $q->whereDate('date', '>=', Carbon::now());
      })
      ->when($request->end != null, function ($q) use ($request){
        return $q->whereDate('date', '<=', Carbon::parse($request->end));
      })
      ->when($request->type != null, function($q) use ($request){
        $q->where('permission_type', $request->type);
      })
      ->when($request->status != null, function($q) use ($request){
        $q->where('status_id', $request->status);
      })
      ->get()
      ->whereIn('user_id', $sub);

    return view('head.permissions.index', [
      'permissions' => $q,
      'types' => PermissionType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }
}
