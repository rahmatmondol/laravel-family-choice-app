<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Http\Requests\BaseRequest;
use App\Models\Reservation;

class PaymentWithWalletFormRequest extends BaseRequest
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
        if (!$reservation->required_payment_step_is_partial && !$reservation->required_payment_step_is_remaining){
          $fail(__('no payment required'));
        }
        if ( $reservation->payment_status == PaymentStatus::Succeeded->value ) {
          $fail(__('site.Reservation Already Paid Successfully'));
        }
        $customer = $reservation->customer;
        if ($reservation->required_payment_step_is_partial) {
          if ($reservation->status != ReservationStatus::Pending->value) {
            $fail(__('site.reservation status must be pending'));
          }
          if ($customer->wallet  < $reservation->required_partial_payment_amount) {
            $fail('no enough wallet');
          }
        }
        if ($reservation->required_payment_step_is_remaining) {
          if ($reservation->status != ReservationStatus::Accepted->value) {
            $fail(__('site.Reservation Still Not Accepted'));
          }
          if ($customer->wallet < $reservation->required_remaining_payment_amount) {
            $fail('no enough wallet');
          }
        }
        if($reservation->refund_partial_payment_info && $reservation->refund_partial_payment_info['status']=='done'){
          $fail(__('site.Partial Payment Already Refunded'));
        }
      }],
    ];
  }
}
