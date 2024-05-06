<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Mail\LetterMail;
use Illuminate\Http\Request;
use App\Models\Admin\PayDeduct;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\Salaries\OpenMonth;

class LetterController extends Controller
{
  use OpenMonth;
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('letters.index', [
      'letters' => Letter::where('user_id', auth()->user()->id)->get()
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'addressee' => 'required|string|max:255|not_in:To whom it may concern,إلى من يهمه الامر, الى من يهمه الامر , الي من يهمه الامر, إلي من يهمه الامر',
      'english' => 'nullable',
      'salary' => 'nullable',
      'loan' => 'nullable',
      'attested' => 'nullable',
      'deduction' => Rule::requiredIf(fn() => $request->attested == 'on')
    ],[
      'addressee.required' => __('The addressee you\'ve entered is invalid'),
      'addressee.string' => __('The addressee you\'ve entered is invalid'),
      'addressee.not_in' => __('The addressee you\'ve entered is invalid'),
      'addressee.max' => __('The addressee you\'ve entered is invalid'),
      'deduction.required' => __('You need to approve deduction of 35 SAR for attestation fees'),
    ]);
    $validated['user_id'] = auth()->user()->id;
    $validated['english'] = isset($validated['english']) ? '1' : '0';
    $validated['salary'] = isset($validated['salary']) ? '1' : '0';
    $validated['loan'] = isset($validated['loan']) ? '1' : '0';
    $validated['attested'] = isset($validated['attested']) ? '1' : '0';
    $validated['deduction'] = isset($validated['deduction']) ? '1' : '0';

    Letter::create($validated);
    if($validated['attested'] == 1)
    {
      $month = $this->openMonth();
      PayDeduct::insert([
        'user_id' => auth()->user()->id,
        'month_id' => $month->id,
        'amount' => '35',
        'description' => 'Chammber of Commerece attesation',
        'type' => '0',
        'code' => '1532',
        'created_at' => now(),
        'updated_at' => now()
      ]);
    }
    $letter = Letter::orderByDesc('created_at')->first();
    Mail::queue(new LetterMail($letter));
    return redirect()->route('letters.index')->with('success', __('You have applied for a letter successfully'));
  }

  private function check($field){

  }

}
