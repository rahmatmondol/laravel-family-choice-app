<?php

namespace App\Services\Payment;

use App\Enums\PaymentStep;
use App\Enums\PaymentType;
use App\Models\Reservation;
use Exception;
use Stripe;

class StripeService
{
  public static function getPaymentIntent($request)
  {
    try {
      $reservation = Reservation::with('customer')->findOrFail($request->reservation_id);
      // Set your secret key. Remember to switch to your live secret key in production.
      Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      $stripe_customer_id = static::getStripeCustomerId($reservation);

      $ephemeralKey = \Stripe\EphemeralKey::create(
        [
          'customer' => $stripe_customer_id,
        ],
        [
          'stripe_version' => '2020-08-27',
        ]
      );
      $payment_step  = $reservation->required_payment_step_is_partial ? PaymentStep::PartialPayment->value : PaymentStep::RemainingPayment->value;

      $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $reservation->required_amount_to_pay_with_card,
        'currency' => 'AED',
        'customer' => $stripe_customer_id,
        'automatic_payment_methods' => [
          'enabled' => 'true',
        ],
        'metadata' => [
          'reservation_id' => $reservation->id,
          'payment_method' => $request->payment_method,
          'payment_step'   => $payment_step,
        ],
      ]);
      info($paymentIntent);


      if ($request->payment_method) {
        self::handlePaymentStep($reservation, $request->payment_method, $payment_step);
      }


      return [
        'paymentIntent'   => $paymentIntent->client_secret,
        'ephemeralKey'    => $ephemeralKey->secret,
        'customer'        => $stripe_customer_id,
        'publishableKey'  => env('STRIPE_KEY')
      ];
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public static function handlePaymentStep($reservation, $paymentMethod, $payment_step)
  {
    $info = '';
    $available_amount_in_wallet = $reservation->customer->wallet;

    if ($payment_step == PaymentStep::PartialPayment->value) {
      if ($paymentMethod == PaymentType::Card->value) {
        $info = [
          'status'  => 'pending',
          'type'    => PaymentType::Card->value,
          'amount'  => $reservation->required_partial_payment_amount,
        ];
      }
      if ($paymentMethod == PaymentType::CardAndWallet->value) {
        $info = [
          'status'  => 'pending',
          'type'    => PaymentType::CardAndWallet->value,
          PaymentType::Card->value   => [
            'status'  => 'pending',
            'amount'  => $reservation->required_partial_payment_amount  - $available_amount_in_wallet,
          ],
          PaymentType::Wallet->value   => [
            'status'  => 'pending',
            'amount'  => $available_amount_in_wallet,
          ]
        ];
      }
      $reservation->update([
        'partial_payment_info' => $info,
      ]);
    } elseif ($payment_step == PaymentStep::RemainingPayment->value) {
      if ($paymentMethod == PaymentType::Card->value) {
        $info = [
          'status'  => 'pending',
          'type'    => PaymentType::Card->value,
          'amount'  => $reservation->required_remaining_payment_amount,
        ];
      }
      if ($paymentMethod == PaymentType::CardAndWallet->value) {
        $info = [
          'status'  => 'pending',
          'type'    => PaymentType::CardAndWallet->value,
          PaymentType::Card->value   => [
            'status'  => 'pending',
            'amount'  => $reservation->required_remaining_payment_amount  - $available_amount_in_wallet,
          ],
          PaymentType::Wallet->value   => [
            'status'  => 'pending',
            'amount'  => $available_amount_in_wallet,
          ]
        ];
      }
      $reservation->update([
        'remaining_payment_info' => $info,
      ]);
    }
  }

  public static function getStripeCustomerId($reservation)
  {
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
    // $endpoint_secret = env('ENDPOINT_SECRET');
    $endpoint_secret = "whsec_1335dc14d639b9906b06f77858152a58d5d30e442e958ad488b5ae8c05a57f5f";
    $payload = @file_get_contents('php://input');
    $event = null;
    // info($payload);

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
        // info($event);
        // info($event['data']['object']['charges']['data']['id']??null);

        return [
          'payment_intent_id'   => $event['data']['object']['id'],
          'reservation_id' => $event['data']['object']['metadata']['reservation_id'] ?? null,
          'payment_method' => $event['data']['object']['metadata']['payment_method'] ?? null,
          'payment_step' => $event['data']['object']['metadata']['payment_step'] ?? null,
          'event_type' => $event->type,
          'charge_id' => $event['data']['object']['charges']['data'][0]['id'] ?? null,
          // 'event_object' => $event,
        ];
      } catch (\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        info($e);
        info($e->getMessage());
        // info('Webhook error while validating signature.');

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
