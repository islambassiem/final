<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Mail\Admin\IqamaRenewal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class IqamaController extends Controller
{
  public function index()
  {
    $iqamas = Document::with('user')->whereHas('user', function ($query) {
      $query->where('active', true)
            ->where('sponsorship_id', '!=', '3')
            ->where('nationality_id' , '>', '1' )
            ->where('document_type_id', '1');
    })->orderBy('date_of_expiry')
      ->get();
    foreach ($iqamas as $iqama) {
      $expiry = Carbon::parse($iqama->date_of_expiry);
      $expiry->addDay()->format('Y-m-d');
      $iqama->hijri = $this->hijri(strtotime($expiry));
    }
    return view('admin.iqama.index', [
      'iqamas' => $iqamas
    ]);
  }


  public function update(string $id, Request $request)
  {
    $pattern = '/^\d{4}-\d{2}-\d{2}$/';
    if (! preg_match($pattern, $request->expiry))
      return redirect()->back();
    $dateArr =  explode("-",$request->expiry);
    $year = $dateArr[0];
    $month = $dateArr[1];
    $day = $dateArr[2];
    if($year[0] == '1'){
      $Arabic = new \ArPHP\I18N\Arabic();
      $correction = $Arabic->mktimeCorrection($month, $year);
      $time = $Arabic->mktime(0, 0, 0, $month, $day, $year, $correction);
      $expiry =  date('Y-m-d' , $time);
    }else{
      $expiry = $request->expiry;
    }
    $iqama = Document::find($id);
    $iqama->update([
      'date_of_expiry' => $expiry
    ]);
    Mail::queue(new IqamaRenewal($iqama));
    return redirect()->back()->with('success', __('admin/iqama.renewalSuccess'));
  }

  private function hijri($time)
  {
    $Arabic = new \ArPHP\I18N\Arabic();
    $Arabic->setDateMode(0);
    $correction = $Arabic->dateCorrection($time);
    return $Arabic->date('Y-m-d', $time, $correction);
  }
}
