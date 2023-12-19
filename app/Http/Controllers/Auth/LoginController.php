<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

  public function __construct()
  {
    return $this->middleware('guest')->only('index');
  }

  public function index()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $validated = $request->validate([
      'empid'    => ['required', Rule::exists('users')->where(fn($query) => $query->where('active', 1))],
      'password' => 'required'
    ],[
      'empid.rule' => 'You are not allowed to log in to the system'
    ]);

    $remember = $request->remember == "on" ? true : false;
    if (Auth::attempt($validated, $remember)) {
      $request->session()->regenerate();
      session()->put('_lang', '_en');
      return redirect()->route('dashboard');
    }
    return redirect()->route('login')->with('error', 'Login information is not correct');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }
}
