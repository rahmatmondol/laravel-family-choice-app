<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
  /**
   * Write code on Method
   *
   * @return response()
   */
  public function showForgetPasswordForm()
  {
    return view('admin.auth.forget-password');
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  public function submitForgetPasswordForm(Request $request)
  {
    $request->validate([
      'email' => 'required|email|exists:admins',
    ]);

    $passwordReset = PasswordReset::updateOrCreate(
      ['email' => $request->email],
      [
        'email' => $request->email,
        'token' => Str::random(64),
      ]
    );

    $admin = Admin::where('email', $request->email)->first();
    if ($admin && $passwordReset) {
      $url =  route('admin.reset.password.get', ['token' => $passwordReset->token]);
      $admin->notify(
        new PasswordResetRequest($url)
      );
    }


    return back()->with('success', __('site.We have e-mailed your password reset link!'));
  }
  /**
   * Write code on Method
   *
   * @return response()
   */
  public function showResetPasswordForm($token)
  {
    $passwordReset = PasswordReset::where('token', $token)->first();
    if (!$passwordReset ||  Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
      return redirect('admin/login')->with('error', __('site.Reset Password Request Is Expired!'));
    }
    return view('admin.auth.reset-password', ['passwordReset' => $passwordReset]);
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  public function submitResetPasswordForm(Request $request)
  {
    $request->validate([
      'email' => 'required|email|exists:admins',
      'token' => 'required',
      'password' => 'required|string|min:6|confirmed',
      'password_confirmation' => 'required'
    ]);

    $updatePassword = DB::table('password_resets')
      ->where([
        'email' => $request->email,
        'token' => $request->token
      ])
      ->first();

    if (!$updatePassword) {
      return back()->withInput()->with('errors', __('site.Reset Password Request Is Expired!'));
    }

    Admin::where('email', $request->email)
      ->update(['password' => Hash::make($request->password)]);

    DB::table('password_resets')->where(['email' => $request->email])->delete();

    return redirect('admin/login')->with('success', __('site.Your password has been changed!'));
  }
}
