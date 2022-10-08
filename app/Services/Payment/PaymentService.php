<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use App\Models\Payment;

class PaymentService
{
  public static function createPaymentRecord(string $payment_intent_id)
  {
    $paymentIntent = StripeService::retrievePaymentIntent($payment_intent_id);

    if ($paymentIntent) {

      Payment::firstOrCreate(
        [
          'payment_intent_id' => $paymentIntent['id'],
          'payment_status' => PaymentStatus::Succeeded->value,
          'reservation_id' => $paymentIntent['metadata']['reservation_id']
        ],
        ['total_fees' => $paymentIntent['amount'], 'event_object' => json_encode($paymentIntent)],
      );
    }
  }
}
