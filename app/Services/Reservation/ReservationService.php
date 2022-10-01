<?php

namespace App\Services\Reservation;

use App\Enums\PaymentStatus;
use App\Models\Reservation;
use App\Notifications\Reservation\ReservationPaidNotification;
use Illuminate\Support\Facades\Notification;

class ReservationService
{

  public static function updatePaymentStatus(int $reservation_id,string $status)
  {
    $reservation = Reservation::find($reservation_id);

    $updated = $reservation->update(['payment_status'=>$status]);

    switch ($status) {
      case PaymentStatus::Succeeded->value:

        Notification::send($reservation->customer, new ReservationPaidNotification($reservation));

        break;

      default:
        # code...
        break;
    }

    return $updated;
  }

  public static function updatePaymentIntent(int $reservation_id , string $payment_intent_id)
  {
    $reservation = Reservation::find($reservation_id);

    $reservation->update(['payment_intent_id'=>$payment_intent_id]);
  }
}
