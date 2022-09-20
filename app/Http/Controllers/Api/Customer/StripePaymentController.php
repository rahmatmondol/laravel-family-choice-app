<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Exception;
use Stripe;

class StripePaymentController extends Controller
{
  use ResponseTrait;

  public function getConnectionToken(Request $request)
  {
    // Set your secret key. Remember to switch to your live secret key in production.
    // See your keys here: https://dashboard.stripe.com/apikeys
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    // In a new endpoint on your server, create a ConnectionToken and return the
    // `secret` to your app. The SDK needs the `secret` to connect to a reader.
    $connectionToken = Stripe\Terminal\ConnectionToken::create();

    return $this->sendResponse($connectionToken, "");
  }

  public function  getPaymentIntent(Request $request)
  {
    try {
      $reservation = Reservation::with('customer')->findOrFail($request->reservation_id);
      // Set your secret key. Remember to switch to your live secret key in production.
      Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      // Use an existing Customer ID if this is a returning customer.
      if ($reservation->customer->stripe_customer_id != null) {
        $stripe_customer_id  = $reservation->customer->stripe_customer_id;
      } else {
        $stripe_customer_id  = (\Stripe\Customer::create())->id;
        // update in db
        $reservation->customer->update([
          'stripe_customer_id' => $stripe_customer_id
        ]);
      }

      $ephemeralKey = \Stripe\EphemeralKey::create(
        [
          'customer' => $stripe_customer_id,
        ],
        [
          'stripe_version' => '2020-08-27',
        ]
      );
      $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $reservation->total_fees,
        'currency' => 'AED',
        'customer' => $stripe_customer_id,
        'automatic_payment_methods' => [
          'enabled' => 'true',
        ],
      ]);
      return $this->sendResponse([
        'paymentIntent' => $paymentIntent->client_secret,
        'ephemeralKey' => $ephemeralKey->secret,
        'customer' => $stripe_customer_id,
        'publishableKey' => env('STRIPE_KEY')
      ], "");
    } catch (Exception $e) {
      return $this->sendResponse($e->getMessage(), "");
    }
  }
}
