<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;

class EnsureCustomerVerified
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */

  use ResponseTrait;
  public function handle($request, Closure $next)
  {
    $customer = getCustomer();

    if (!$customer || $customer->verified != "1") {

      return $this->sendError(__('site.User not verified', ''));
    }

    return $next($request);
  }
}
