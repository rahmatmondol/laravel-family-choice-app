<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\Reservation;

class PaymentService
{


  public static function createPaymentRecord(string $payment_intent_id)
  {
    $paymentIntent = StripeService::retrievePaymentIntent($payment_intent_id);

    if ($paymentIntent) {

      $reservation = Reservation::findOrFail($paymentIntent['metadata']['reservation_id']);

      Payment::firstOrCreate(
        [
          'payment_intent_id' => $paymentIntent['id'],
          'payment_status' => PaymentStatus::Succeeded->value,
          'reservation_id' => $paymentIntent['metadata']['reservation_id']
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
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }
}
