<?php

namespace App\Services\Reservation;

use App\Enums\PaymentStatus;
use App\Models\Reservation;
use App\Notifications\Reservation\ReservationPaidNotification;
use Illuminate\Support\Facades\Notification;

class ReservationService
{

  public static function handleReservationNotification(Reservation $reservation, string $status)
  {
    switch ($status) {
      case PaymentStatus::Succeeded->value:

        Notification::send($reservation->customer, new ReservationPaidNotification($reservation));

        break;

      default:
        # code...
        break;
    }

  }

  public static function makeReservationPaid(string $reservation_id, string $payment_intent_id)
  {
    $reservation = Reservation::find($reservation_id);

    $reservation->update(['payment_status' => PaymentStatus::Succeeded->value, 'payment_intent_id' => $payment_intent_id]);
  }

  public static function getReservationPaidWillNotified(){

    return Reservation::where('notification_is_sent',false)->get();
  }

}
