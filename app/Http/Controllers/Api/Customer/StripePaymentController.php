<?php

namespace App\Http\Controllers\Api\Customer;

use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPaymentIntentRequest;
use App\Models\Reservation;
use App\Services\Payment\StripeService;
use App\Services\Reservation\ReservationService;

class StripePaymentController extends Controller
{
  use ResponseTrait;

  public function  getPaymentIntent(GetPaymentIntentRequest $request)
  {
    return $this->sendResponse(StripeService::getPaymentIntent($request), "");
  }

  // stripe trigger payment_intent.succeeded --add payment_intent:metadata.payment_method=card --add payment_intent:metadata.reservation_id=58 --add payment_intent:metadata.payment_step=partial_payment

  // to test this api  run this in terminal
  // stripe listen --forward-to  http://127.0.0.1:8002/api/stripe/webhook
  //  stripe trigger  payment_intent.succeeded  >> in another terminal
  public function paymentWebHook(Request $request)
  {
    $eventObject  = StripeService::getEventObject(env('ENDPOINT_SECRET_WEB_HOOK'));
    if ( // succeeded payment
      isset($eventObject['event_type']) &&
      $eventObject['event_type'] == 'payment_intent.succeeded' &&
      isset($eventObject['payment_intent_id']) &&
      isset($eventObject['payment_method']) &&
      isset($eventObject['reservation_id'])
    ) {
      info($eventObject);
      $reservation = Reservation::find($eventObject['reservation_id']);
      $status  = ReservationService::getPaymentStatus($eventObject['event_type']);

      info($status);
      if ($status == PaymentStatus::Succeeded->value) {
        ReservationService::handleWebHookPaymentMethod($reservation, $eventObject);
      }

      ReservationService::updateReservationPaymentStatus($reservation, $eventObject);
      http_response_code(200);
    } elseif ( // payment_failed
      isset($eventObject['event_type']) &&
      $eventObject['event_type'] == 'payment_intent.payment_failed' &&
      isset($eventObject['payment_intent_id']) &&
      isset($eventObject['payment_method']) &&
      isset($eventObject['reservation_id'])
    ) {
      $reservation = Reservation::findOrFail($eventObject['reservation_id']);
      $reservation->update([
        'payment_notification' => [
          'type' => $eventObject['payment_step'],
          'customer_notified' => false,
          'payment_intent_id' => $eventObject['payment_intent_id'],
        ]
      ]);

      info('mam payment failed');
    }
  }

  // to test this api  run this in terminal
  // stripe listen --forward-to  http://127.0.0.1:8002/api/stripe/refund-partial-payment-webhook
  public function refundPartialPaymentWebhook(Request $request)
  {
    // info($request->all());
    $eventObject  = StripeService::getEventObject(env('ENDPOINT_SECRET_REFUND_PARTIAL_PAYMENT'));
    // info($eventObject);

    if ($eventObject['reservation_id'] && $eventObject['event_type'] == 'charge.refunded') {
      $reservation = Reservation::find($eventObject['reservation_id']);
      $reservation->update([
        'payment_notification' => [
          'type' => $eventObject['event_type'],
          'customer_notified' => false,
          'payment_intent_id' => $eventObject['payment_intent_id'] ?? null,
        ]
      ]);
    }

    http_response_code(200);
  }
}
