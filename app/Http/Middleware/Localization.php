<?php

namespace App\Http\Middleware;

use Closure;
use LaravelLocalization;

class Localization
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {

    // Check header request and determine localizaton
    $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';

    app()->setLocale($local);

    // continue request
    return $next($request);
  }
}
