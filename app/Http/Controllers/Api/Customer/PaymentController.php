<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Stripe;

class PaymentController extends Controller
{
  use ResponseTrait;

  public function getConnectionToken(Request $request)
  {
    // Set your secret key. Remember to switch to your live secret key in production.
    // See your keys here: https://dashboard.stripe.com/apikeys
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    // In a new endpoint on your server, create a ConnectionToken and return the
    // `secret` to your app. The SDK needs the `secret` to connect to a reader.
    $connectionToken = \Stripe\Terminal\ConnectionToken::create();

    return $this->sendResponse($connectionToken, "");
  }
}
