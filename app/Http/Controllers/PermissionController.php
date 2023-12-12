<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attachment;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionType;
use App\Models\PermissionDetail;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }


  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('permissions.index', [
      'permissions' => Permission::with(['detail', 'attachment'])->where('user_id', auth()->user()->id)->orderByDesc('id')->get(),
      'types' => PermissionType::all(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PermissionRequest $request)
  {
    $validated = $request->validated();
    $validated['user_id'] = auth()->user()->id;
    $validated['status_id'] = 0;
    $start = Carbon::parse($validated['from']);
    $end = Carbon::parse($validated['to']);
    $diff = $end->floatDiffInHours($start);
    if($diff > 4){
      return redirect()->back()->with('error', 'The permission cannot be more than 4 hours');
    }
    Permission::create($validated);
    $latest_id = Permission::latest('id')->first();
    $this->permissionDetial($request, $latest_id->id);
    $this->attach($request, $latest_id);
    return redirect()->back()->with('success', 'You have applied for a permission successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return view('permissions.show', [
      'permission' => Permission::with(['detail', 'attachment'])->find($id)
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $permission = Permission::find($id);
    if($permission->status_id > 0){
      return redirect()->back()->with('error', 'An action has been taken on your permission; you cannot delete it');
    }
    $detail = PermissionDetail::where('permission_id', $permission->id)->first();
    $attachment = Attachment::where('attachmentable_type', 'App\Models\Permission')->where('attachmentable_id', $permission->id)->first();
    if($detail){
      $detail->delete();
    }
    if($attachment){
      $attachment->delete();
    }
    $permission->delete();
    return redirect()->back()->with('success', 'You have deleted your permission successfully');
  }

  private function permissionDetial(PermissionRequest $request, string $id)
  {
    PermissionDetail::create([
      'permission_id' => $id,
      'employee_notes' => $request->employee_notes,
      'employee_time' => Carbon::now(),
      'head_status' => '0',
      'hr_status' => '0'
    ]);
  }

  private function attach(PermissionRequest $request, Permission $latest)
  {
    if($request->has('attachment'))
    {
      $filepath = $request->file('attachment')->store(auth()->user()->id . '/permissions', 'public');
      $latest->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '9',
        'link' => $filepath,
        'title' => 'permission'
      ]);
    }
  }
}
