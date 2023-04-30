<?php

namespace App\Console\Commands;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Services\NotificationService;
use App\Services\Payment\PaymentService;
use App\Services\Reservation\ReservationService;
use Exception;
use Illuminate\Console\Command;

class HandlePaymentReservation extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */

  protected $signature = 'handle:paymentReservation';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {

    app()->setLocale('ar');

    // foreach (ReservationService::getReservationsWillNotified() as $reservation) {

    //   PaymentService::createPaymentRecord($reservation,$reservation->payment_intent_id);

    //   NotificationService::sendReservationNotification('payment_status.' . $reservation->payment_status, $reservation);

    //   ReservationService::makeReservationNotified($reservation);
    // }

    // dd(ReservationService::getSucceededPartialPaymentReservations());
    foreach (ReservationService::getSucceededPartialPaymentReservations() as $reservation) {

      $payment_intent_id = $reservation->partial_payment_intent_id;
      if ($payment_intent_id) {
        PaymentService::createPaymentRecord($reservation, 'partial_payment', $payment_intent_id, 'succeeded');
      }

      NotificationService::sendReservationNotification('partial_payment.succeeded', $reservation);

      $reservation->update([
        'partial_payment_info->customer_notified' =>true,
      ]);

    }


    foreach (ReservationService::getFailedPartialPaymentReservations() as $reservation) {

      $payment_intent_id = $reservation->failed_payment_notification['payment_intent_id'] ?? null;
      if ($payment_intent_id) {
        PaymentService::createPaymentRecord($reservation, 'partial_payment', $payment_intent_id, 'failed');
      }

      NotificationService::sendReservationNotification('partial_payment.failed', $reservation);

      $reservation->update([
        'failed_payment_notification' =>null,
      ]);
    }


    foreach (ReservationService::getSucceededRemainingPaymentReservations() as $reservation) {

      $payment_intent_id = $reservation->remaining_payment_intent_id;
      if ($payment_intent_id) {
        PaymentService::createPaymentRecord($reservation, 'remaining_payment', $payment_intent_id, 'succeeded');
      }

      NotificationService::sendReservationNotification('remaining_payment.succeeded', $reservation);

      $reservation->update([
        'remaining_payment_info->customer_notified' =>true,
      ]);

    }

    foreach (ReservationService::getFailedRemainingPaymentReservations() as $reservation) {

      $payment_intent_id = $reservation->failed_payment_notification['payment_intent_id'] ?? null;
      if ($payment_intent_id) {
        PaymentService::createPaymentRecord($reservation, 'remaining_payment', $payment_intent_id, 'failed');
      }

      NotificationService::sendReservationNotification('remaining_payment.failed', $reservation);

      $reservation->update([
        'failed_payment_notification' =>null,
      ]);
    }
  }
}
