<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
  protected function deleteToken($email){
    DB::table('password_reset_tokens')->where(['email' => $email])->delete();
  }

  public function resetPassword($token)
  {
    return view('auth.reset-password', ['token' => $token]);
  }

  public function resetPasswordPost(ResetPasswordRequest $request)
  {
    $updatePassword = DB::table('password_reset_tokens')->where([
      'email' => $request->email,
      'token' => $request->token
    ])->first();

    if($updatePassword){
      $created_at = strtotime($updatePassword->created_at);
      $diff = time() - $created_at;
      if($diff >= 5 * 60 ){
        $this->deleteToken($request->email);
        return redirect()->route('login')->with('error', 'The link has expired, you can press forgot password again to reset your password!');
      }
      User::where(['email' => $request->email])->update(['password' => Hash::make($request->password)]);
      $this->deleteToken($request->email);
      return redirect()->route('login')->with('success', 'Password reset successfully');
    }
    return redirect()->route('login')->with('error', 'The link has expired, you can press forgot password again to reset your password !');
  }
}
