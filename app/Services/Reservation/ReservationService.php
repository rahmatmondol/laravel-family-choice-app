<?php

namespace App\Services\Reservation;

use App\Enums\PaymentStatus;
use App\Models\Reservation;
use App\Notifications\Reservation\ReservationPaidNotification;
use Illuminate\Support\Facades\Notification;

class ReservationService
{

  public static function makeReservationPaid(int $reservation_id, string $payment_intent_id)
  {
    $reservation = Reservation::find($reservation_id);

    $reservation->update(['payment_status' => PaymentStatus::Succeeded->value, 'payment_intent_id' => $payment_intent_id]);
  }

  public static function makeReservationNotified(Reservation $reservation)
  {
    $reservation->update(['notification_is_sent'=>true]);
  }

  public static function getPaidReservationsWillNotified(){

    return Reservation::where('notification_is_sent',false)->whereNotNull('payment_intent_id')->get();
  }

}
