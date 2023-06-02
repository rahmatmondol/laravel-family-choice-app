<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentType;
use App\Http\Requests\BaseRequest;
use App\Models\Reservation;
use Illuminate\Validation\Rule;

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
      'reservation_id' => [
        'bail', 'required', 'exists:reservations,id', function ($attribute, $value, $fail) use ($reservation) {
          if (!$reservation->can_refund_partial_payment || (isset($reservation->refund_partial_payment_info) && $reservation->refund_partial_payment_info['status'] == 'done')) {
            $fail(__('can not refund partial payment'));
          }
        }
      ],
      'refund_type' => ['nullable', 'in:card,wallet,card_and_wallet', Rule::requiredIf(function () use ($reservation) {
        return isset($reservation->partial_payment_info) && $reservation->partial_payment_info['type'] == PaymentType::Card->value
          ? true
          : false;
      })],
    ];
  }
}
