<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Payment;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPaymentIntentRequest;
use App\Services\Payment\StripeService;

class StripePaymentController extends Controller
{
  use ResponseTrait;

  public function  getPaymentIntent(GetPaymentIntentRequest $request)
  {
    return $this->sendResponse(StripeService::getPaymentIntent($request), "");
  }

  // to test this api  run this in terminal
  // stripe listen --forward-to  http://127.0.0.1:8000/api/stripe/webhooks-payment-success
  //  stripe trigger  payment_intent.succeeded  >> in another terminal
  public function webHooksPaymentSuccess(Request $request)
  {
    $eventObject  = StripeService::getEventObject();
    if (
      isset($eventObject['event_type']) &&
      $eventObject['event_type'] == 'payment_intent.succeeded' &&
      isset($eventObject['payment_intent_id'])
    ) {
      Payment::firstOrCreate(
        ['payment_intent_id' => $eventObject['payment_intent_id'], 'payment_status' => PaymentStatus::Succeeded->value],
        ['reservation_id'    => $eventObject['reservation_id'], 'event_object' => json_encode($eventObject['event_object'])],
      );
    }

    http_response_code(200);
  }
}
