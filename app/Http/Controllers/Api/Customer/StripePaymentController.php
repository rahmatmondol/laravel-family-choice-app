<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPaymentIntentRequest;
use App\Services\Payment\StripeService;
use App\Services\Reservation\ReservationService;

class StripePaymentController extends Controller
{
  use ResponseTrait;

  public function  getPaymentIntent(GetPaymentIntentRequest $request)
  {
    return $this->sendResponse(StripeService::getPaymentIntent($request), "");
  }

  // to test this api  run this in terminal
  // stripe listen --forward-to  http://127.0.0.1:8000/api/stripe/webhook-payment-success
  //  stripe trigger  payment_intent.succeeded  >> in another terminal
  public function paymentWebHook(Request $request)
  {
    $eventObject  = StripeService::getEventObject();

    if (
      isset($eventObject['event_type']) &&
      in_array($eventObject['event_type'],['payment_intent.succeeded','payment_intent.failed']) &&
      isset($eventObject['payment_intent_id']) &&
      isset($eventObject['reservation_id'])
    ) {
      info($eventObject['event_type']);
      info('payment_intent.succeeded');

      ReservationService::updateReservationPaymentStatus($eventObject['reservation_id'], $eventObject['payment_intent_id'], $eventObject['event_type']);
      http_response_code(200);

    }

  }
}
