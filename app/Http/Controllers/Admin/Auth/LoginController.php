<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
  use AuthenticatesUsers;

  /**
   * Where to redirect admins after login.
   *
   * @var string
   */
  // protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['guest'])->except('logout');
  }

  public function showLoginForm()
  {
    return view('admin.auth.login');
  }

  public function login(Request $request)
  {
    $this->validate($request, [
      'email'   => 'required|exists:admins,email',
      'password' => 'required|min:6'
    ]);

    if (Auth::guard('admin')->attempt([
      'email' => $request->email,
      'password' => $request->password,
      'status' => 1
    ], $request->get('remember'))) {
      return redirect()->intended(route('admin.dashboard'));
      return redirect()->intended(route('home'));
    }
    return back()->withInput($request->only('phone', 'remember'))->withErrors(__('site.Invalid Credentials'));;
  }

}
