<?php

namespace App\Http\Controllers\Admin;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Admin\IqamaRenewal;
use Illuminate\Support\Facades\Mail;

class IqamaController extends Controller
{
  public function index()
  {
    $iqamas = Document::whereHas('user', function ($query) {
      $query->where('active', true)
            ->where('sponsorship_id', '!=', '3')
            ->where('nationality_id' , '>', '1' )
            ->where('document_type_id', '1');
    })->orderBy('date_of_expiry')
      ->get();
    return view('admin.iqama.index', [
      'iqamas' => $iqamas
    ]);
  }


  public function update(string $id, Request $request)
  {
    $validated = $request->validate([
      'expiry' => 'required|after_or_equal:now|before_or_equal:'. now()->addYear()
    ]);
    $iqama = Document::find($id);
    $iqama->update([
      'date_of_expiry' => $validated['expiry']
    ]);
    Mail::send(new IqamaRenewal($iqama));
    return redirect()->back()->with('success', __('admin/iqama.renewalSuccess'));
  }
}
