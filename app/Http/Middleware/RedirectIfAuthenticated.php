<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @param  string|null  ...$guards
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, ...$guards)
  {
    $guards = empty($guards) ? [null] : $guards;

    if (count($guards)) {
      // dd($guards[0]);

      switch ($guards[0]) {
        case 'admin':
          if (Auth::guard($guards[0])->check()) {
            return redirect('admin/dashboard');
          }
          break;
        case 'school':
          if (Auth::guard($guards[0])->check()) {
            return redirect('school/dashboard');
          }
          break;
        case 'web':
          if (Auth::guard($guards[0])->check()) {
            return redirect('/');
          }
          break;
        default:
          // return redirect('/admin/login');
          // return redirect('/');
          break;
      }
    }

    return $next($request);
  }
}
