<?php

namespace App\Http\Controllers\School\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\School\BaseController;

class LoginController extends Controller
{
  use AuthenticatesUsers;

  /**
   * Where to redirect schools after login.
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
    return view('school.auth.login');
  }

  public function login(Request $request)
  {
    $this->validate($request, [
      'email'   => 'required|exists:schools,email',
      'password' => 'required|min:6'
    ]);

    if (Auth::guard('school')->attempt([
      'email' => $request->email,
      'password' => $request->password,
      'status' => 1
    ], $request->get('remember'))) {
      // dd(Auth::guard('school')->user());
      return redirect()->intended(route('school.dashboard'));
      return redirect()->intended(route('home'));
    }
    return back()->withInput($request->only('phone', 'remember'))->withErrors(__('site.Invalid Credentials'));;
  }

}
