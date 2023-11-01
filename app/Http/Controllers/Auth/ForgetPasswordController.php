<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgetPasswordController extends Controller
{
  public function forgotPassword()
  {
    return view('auth.forgot-password');
  }

  public function forgotPasswordPost(ForgotPasswordRequest $request)
  {
    if(!$request){
      return back()->with('error', 'there is an error');
    }
    $token = Str::random(64);
    DB::table('password_reset_tokens')->insert([
      'email'       => $request->email,
      'token'       => $token,
      'created_at'  => Carbon::now()
    ]);
    Mail::send('emails.auth.forgot-password', ['token' => $token], function ($message) use ($request){
      $message->to($request->email);
      $message->subject('Password Reset');
    });
    return redirect()->route('forgot-password')->with('success', 'Kindly Check your email. The link in the email expires in 5 minutes');
  }


}
