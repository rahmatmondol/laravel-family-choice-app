<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Arr;
use App\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
  use ResponseTrait;

  /**
   * A list of the exception types that are not reported.
   *
   * @var array<int, class-string<Throwable>>
   */
  protected $dontReport = [
    //
  ];

  /**
   * A list of the inputs that are never flashed for validation exceptions.
   *
   * @var array<int, string>
   */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   *
   * @return void
   */
  public function register()
  {
    $this->reportable(function (Throwable $e) {
      //
      try {
        if (app()->environment('production')) {
          Log::channel('slack')->critical($e->getMessage());
        }
      } catch (Exception $e) {
        Log::channel('slack')->critical($e->getMessage());
      }
    });
  }

  protected function unauthenticated($request, AuthenticationException $exception)
  {
    if (request()->is('api/*') || $request->expectsJson()) {
      return $this->sendError(__('site.Unauthenticated'), '');
    }

    $guard = Arr::get($exception->guards(), 0);

    switch ($guard) {
      // case 'customer':
      //   $login = 'customer.login';
      //   break;
      default:
        $login = 'admin.login';
        break;
    }
    return redirect()->guest(route($login));
  }
}
