<?php

namespace App\Http\Controllers\Api\Customer;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RefundPartialPaymentFormRequest;
use App\Http\Resources\ReservationResource;
use App\Services\Reservation\RefundPartialPaymentService;

class RefundController extends Controller
{
  use ResponseTrait;

  public function  refundPartialPayment(RefundPartialPaymentFormRequest $request)
  {
    $reservation = RefundPartialPaymentService::refundPartialPayment($request->reservation_id);
    return $this->sendResponse(new ReservationResource($reservation), "");
  }
}
