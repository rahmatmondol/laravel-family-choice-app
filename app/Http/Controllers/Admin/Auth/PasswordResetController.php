<?php
namespace App\Http\Controllers\Admin\Auth;


use Carbon\Carbon;
use App\Models\Admin;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Traits\Admin\AdminResetPasswordTrait;
use App\Http\Requests\Admin\AdminResetPasswordFormRequest;
use App\Http\Requests\Admin\AdminSendResetPasswordLinkFormRequest;

class PasswordResetController extends BaseController
{

  use AdminResetPasswordTrait;

  public function forget_password()
  {
    return view("hospital.authAdmin.passwords.email");
  }

  public function send_reset_password(AdminSendResetPasswordLinkFormRequest $request)
  {

    $data = $this->createToken($request);

    session()->flash('success', __('site.reset passport link already sent'));

    return redirect()->route("home");
  }

  public function find($token)
  {

    $passwordReset = PasswordReset::where('token', $token)->first();
    if (!$passwordReset) {
      return redirect()->route("home");
    }

    if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
      $passwordReset->delete();
      return redirect()->route("home");
    }

    return view('hospital.authAdmin.passwords.reset', compact('passwordReset'));
  }

  public function reset(AdminResetPasswordFormRequest $request)
  {

    $passwordReset = PasswordReset::where([
      ['token', $request->token],
    ])->first();

    $user = Admin::where('email', $passwordReset->email)->first();

    $user->password = bcrypt($request->password);
    $user->save();
    $passwordReset->delete();

    session()->flash('success', __('site.Record Updated Successfully'));

    return redirect()->route("hospital.login");
  }
}
