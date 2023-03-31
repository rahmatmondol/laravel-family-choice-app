<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
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
    $reservation  = Reservation::findOrFail($this->reservation_id);
    return [
      'reservation_id' => ['bail', 'required', 'exists:reservations,id', function ($attribute, $value, $fail) use ($reservation) {
        if ($reservation->required_payment_step_is_partial  && $reservation->status != ReservationStatus::Pending->value) {
          $fail(__('site.reservation status must be pending'));
        }
        if ($reservation->required_payment_step_is_remaining &&  $reservation->status != ReservationStatus::Accepted->value) {
          $fail(__('site.Reservation Still Not Accepted'));
        }
        if ($reservation->payment_status == PaymentStatus::Succeeded->value) {

          $fail(__('site.Reservation Already Paid Successfully'));
        }
      }],
      'payment_method' => ['bail', 'required', 'in:card,card_and_wallet', function ($attribute, $value, $fail) use ($reservation) {
        $customer = $reservation->customer;
        if ($value == PaymentType::CardAndWallet->value && $customer->wallet == 0) {
          $fail('not allowed to pay with wallet');
        }
      }]
    ];
  }
}
