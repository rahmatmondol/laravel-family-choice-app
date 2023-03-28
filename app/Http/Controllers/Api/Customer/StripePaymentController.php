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

  // to test this api  run this in terminal
  // stripe listen --forward-to  http://127.0.0.1:8000/api/stripe/webhook
  //  stripe trigger  payment_intent.succeeded  >> in another terminal
  public function paymentWebHook(Request $request)
  {
    $eventObject  = StripeService::getEventObject();
    info($eventObject);
    if (
      isset($eventObject['event_type']) &&
      // in_array($eventObject['event_type'],['payment_intent.succeeded','payment_intent.payment_failed']) &&
      isset($eventObject['payment_intent_id']) &&
      isset($eventObject['payment_method']) &&
      isset($eventObject['reservation_id'])
    ) {
      $reservation = Reservation::find($eventObject['reservation_id']);
      info($eventObject['event_type']);
      $status  = ReservationService::getPaymentStatus($eventObject['event_type']);

      if($status == PaymentStatus::Succeeded->value  ){
        ReservationService::handleWebHookPaymentMethod($reservation,$eventObject['payment_method'],$eventObject['payment_step']);
      }

      // ReservationService::updateReservationPaymentStatus($eventObject['reservation_id'], $eventObject['payment_intent_id'], $eventObject['event_type']);
      // ReservationService::updateReservationPaymentStatus($reservation,$eventObject);
      http_response_code(200);
    }

  }

  // to test this api  run this in terminal
  // stripe listen --forward-to  http://127.0.0.1:8000/api/stripe/refund-partial-paymen
  //  stripe trigger charge.refunded  >> in another terminal
  public function refundPartialPayment(Request $request){
    $eventObject  = StripeService::getEventObject();
    info($eventObject);
  }
}
