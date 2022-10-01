<?php

namespace App\Services\Payment;

use App\Models\Reservation;
use App\Traits\ResponseTrait;
use Exception;
use Stripe;

class StripeService
{
  use ResponseTrait;

  public static function getPaymentIntent($request)
  {
    try {
      $reservation = Reservation::with('customer')->findOrFail($request->reservation_id);
      // Set your secret key. Remember to switch to your live secret key in production.
      Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      $stripe_customer_id= static::getStripeCustomerId($reservation);

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
        'metadata' => [
          'reservation_id' => $reservation->id,
        ],
      ]);
      return [
        'paymentIntent' => $paymentIntent->client_secret,
        'ephemeralKey' => $ephemeralKey->secret,
        'customer' => $stripe_customer_id,
        'publishableKey' => env('STRIPE_KEY')
      ];
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public static function getStripeCustomerId($reservation){
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
    return $stripe_customer_id;
  }

  public static function getEventObject()
  {
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    // $endpoint_secret = 'whsec_RWeD4gOAbAq0L0r0FExoQUvpqXXGlANS';
    $endpoint_secret = env('ENDPOINT_SECRET');
    $payload = @file_get_contents('php://input');
    $event = null;

    if ($endpoint_secret) {
      // Only verify the event if there is an endpoint secret defined
      // Otherwise use the basic decoded event
      $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
      try {
        $event = \Stripe\Webhook::constructEvent(
          $payload,
          $sig_header,
          $endpoint_secret
        );

        return [
          'payment_intent_id'   => $event['data']['object']['id'],
          'reservation_id' => $event->metadata->reservation_id?? null,
          'event_type' => $event->type,
          'event_object' => $event,
        ];
      } catch (\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        info('Webhook error while validating signature.');

        http_response_code(400);
        exit();
      }
    }
  }
  public static function retrievePaymentIntent(string $paymentIntentId)
  {
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    return  $stripe->paymentIntents->retrieve($paymentIntentId, []);
  }
}
