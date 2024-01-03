<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;



class GoogleController extends Controller
{
  public function googlePage()
  {
    return Socialite::driver('google')->redirect();
  }

  public function googleCallBack()
  {
    $user = Socialite::driver('google')->user();
    $finduser = User::where('email', $user->email)->first();
    if(!$finduser){
      return redirect()->route('login')->with('error', 'Please use your official email not your personal email');
    }
    Auth::login($finduser);
    session()->put('_lang', '_en');
    return redirect()->route('dashboard');
  }
}
