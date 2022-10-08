<?php

namespace App\Services\Reservation;

use App\Enums\PaymentStatus;
use App\Models\Reservation;

class ReservationService
{

  public static function updateReservationPaymentStatus(int $reservation_id, string $payment_intent_id, string $event_type)
  {
    $reservation = Reservation::find($reservation_id);
    $status  = self::getPaymentStatus($event_type);
    if ($status != $reservation->payment_status) {
      $reservation->update(['payment_status' => $status, 'payment_intent_id' => $payment_intent_id]);
      self::makeReservationNotNotified($reservation); // to handle new reservation status
    }
  }

  public static function makeReservationNotified(Reservation $reservation)
  {
    $reservation->update(['notification_is_sent' => true]);
  }

  /**
   * make notification_is_sent with false
   *
   * make reservation not notified to send  new status  for reservation
   * ex: if current payment status is succeeded then refunded we need to notify customer with thant reservation is refunded
   * @param Reservation $reservation
   * @return void
   **/
  public static function makeReservationNotNotified(Reservation $reservation)
  {
    $reservation->update(['notification_is_sent' => false]);
  }

  public static function getReservationsWillNotified()
  {
    return Reservation::with(['school','customer','child'])->where('notification_is_sent', false)->whereNotNull('payment_intent_id')->get();
  }

  public static function getPaymentStatus($event)
  {
    $status = [
      'payment_intent.succeeded' =>  PaymentStatus::Succeeded->value,
      'payment_intent.failed'    =>  PaymentStatus::Failed->value,
    ];
    return $status[$event] ?? null;
  }
}
