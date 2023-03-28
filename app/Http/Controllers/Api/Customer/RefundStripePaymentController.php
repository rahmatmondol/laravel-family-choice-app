<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPaymentIntentRequest;
use App\Models\Reservation;
use App\Services\Payment\StripeService;
use App\Services\Reservation\ReservationService;

class RefundStripePaymentController extends Controller
{
  use ResponseTrait;

  // public function  refundPartialPayment(RefundPartialPaymentFormRequest $request)
  // {
  //   return $this->sendResponse(StripeService::getPaymentIntent($request), "");
  // }
}
