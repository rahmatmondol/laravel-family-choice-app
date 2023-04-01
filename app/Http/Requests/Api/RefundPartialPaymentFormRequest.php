<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Models\Reservation;

class RefundPartialPaymentFormRequest extends BaseRequest
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
        if (!$reservation->can_refund_partial_payment){
          $fail(__('can not refund partial payment'));
        }
      }],
    ];
  }
}
