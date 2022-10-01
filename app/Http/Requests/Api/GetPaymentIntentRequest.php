<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Http\Requests\BaseRequest;
use App\Models\Reservation;

class GetPaymentIntentRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'reservation_id' => ['bail','required','exists:reservations,id',function($attribute,$value,$fail){

        $reservation  = Reservation::find($value);

        // if($reservation->status != ReservationStatus::Accepted->value){

        //   $fail(__('site.Reservation Still Not Accepted'));
        // }
        // if($reservation->payment_status == PaymentStatus::Succeeded->value){

        //   $fail(__('site.Reservation Already Paid Successfully'));
        // }
      }],
    ];
  }
}
