<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Verification;

trait AuthenticateCustomer
{

  public function createAuthToken($object)
  {
    $tokenResult = $object->createToken('Personal Access Token');
    $token = $tokenResult->token;

    if (request()->remember_me)
      $token->expires_at = Carbon::now()->addWeeks(1);
    $token->save();

    return $tokenResult;
  }

  public function checkInputType($value)
  {
    $type = '';
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $type = 'email';
    } else {
      $type = 'phone';
    }
    return $type;
  }

  public function credentials($credentials)
  {
    $type  = $this->checkInputType(request('email'));

    if ($type == 'email') {
      $credentials['email'] = request()->get('email');
    } else {
      $credentials['phone'] = request()->get('email');
    }
    return $credentials;
  }
}
