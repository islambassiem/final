<?php

namespace App\Http\Controllers\Head;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PermissionDetail;
use App\Models\Tables\WorkflowStatus;
use App\Notifications\PermissionAction;

class HeadPermissionController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index(Request $request)
  {
    $sub = User::where('active', '1')->where('head', auth()->user()->id)->pluck('id')->toArray();
    $q = Permission::with('user', 'detail')
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
      ->orderByDesc('id')
      ->get()
      ->whereIn('user_id', $sub);

    return view('head.permissions.index', [
      'permissions' => $q,
      'types' => PermissionType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }

  public function show(string $id)
  {
    return view('head.permissions.show', [
      'permission' => Permission::with(['detail', 'attachment', 'user'])->find($id)
    ]);
  }

  public function update(string $id, Request $request)
  {
    $permission = Permission::find($id);
    $user = User::find($permission->user_id);
    $detail = PermissionDetail::where('permission_id', $permission->id)->first();
    if($detail->head_time == null){
      $detail->update([
        'head_status' => $request->action,
        'head_notes' => $request->head_notes,
        'head_time' => Carbon::now()
      ]);
      $user->notify(new PermissionAction($permission));
      return redirect()->route('sLeave.index')->with('success', __('You have taken an action successfully'));
    }
    return redirect()->route('sLeave.index')->with('error', __('You have taken an action already'));
  }
}
