<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\Reservation;

class PaymentService
{

  public static function createPaymentRecord(Reservation $reservation, string $payment_intent_id)
  {
    $paymentIntent = StripeService::retrievePaymentIntent($payment_intent_id);
    if ($paymentIntent) {

      Payment::firstOrCreate(
        [
          'payment_intent_id' => $paymentIntent['id'],
          'payment_status' => $reservation->payment_status,
          'reservation_id' => $reservation->id
        ],
        ['total_fees' => $paymentIntent['amount'],'school_id' => $reservation->school->id, 'event_object' => json_encode($paymentIntent)],
      );
    }
  }

  public static function listPayments($request)
  {
    return  Payment::whenSearch()
      ->whenStatus($request->payment_status)
      ->WhenSchool(getAuthSchool()?getAuthSchool()->id : $request->school_id)
      ->with(['school','reservation.customer'])
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }
}
