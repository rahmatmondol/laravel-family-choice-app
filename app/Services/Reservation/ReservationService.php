<?php

namespace App\Services\Reservation;

use App\Enums\PaymentStatus;
use App\Enums\PaymentStep;
use App\Enums\PaymentType;
use App\Models\Reservation;
use App\Traits\Customer\WalletTrait;

class ReservationService
{
  use WalletTrait;
  public static function updateReservationPaymentStatus($reservation, $eventObject)
  {
    $payment_intent_id = $eventObject['payment_intent_id'];
    $event_type        = $eventObject['event_type'];

    $status  = self::getPaymentStatus($event_type);

    if ($status != $reservation->payment_status) {
      self::makeReservationNotNotified($reservation); // to handle new reservation status
      if ($eventObject['payment_step'] == PaymentStep::RemainingPayment->value) {
        $reservation->update(['payment_status' => $status, 'payment_intent_id' => $payment_intent_id]);
      }
    }
  }

  public static function handleWebHookPaymentMethod($reservation, $eventObject)
  {
    if ($eventObject['payment_step'] == PaymentStep::PartialPayment->value) {
      self::handlePartialPaymentWebHook($reservation, $eventObject);
    } elseif ($eventObject['payment_step'] == PaymentStep::RemainingPayment->value) {
      self::handleRemainingPaymentWebHook($reservation, $eventObject);
    }
  }

  public static function handlePartialPaymentWebHook($reservation, $eventObject)
  {
    if ($eventObject['payment_method'] == PaymentType::Card->value) {
      $reservation->update([
        'partial_payment_info->customer_notified' => false,
        'partial_payment_info->status' => 'done',
        'partial_payment_info->charge_id' => $eventObject['charge_id'],
        'partial_payment_info->payment_intent_id' => $eventObject['payment_intent_id'],
      ]);
    } elseif ($eventObject['payment_method'] == PaymentType::CardAndWallet->value) {

      $reservation->update([
        'partial_payment_info->customer_notified' => false,
        'partial_payment_info->card->status'    => 'done',
        'partial_payment_info->card->charge_id' => $eventObject['charge_id'],
        'partial_payment_info->card->payment_intent_id' => $eventObject['payment_intent_id'],
      ]);
      $description = " خصم قيمة الدفع  المقدم للحجز رقم  " . $reservation->id;
      $amount = $reservation->partial_payment_info[PaymentType::Wallet->value]['amount'];
      if ($reservation->customer->wallet >= $amount) {
        $data = [
          'type'           => 'debit',
          'description'    => $description,
          'amount'         => $amount,
          'customer_id'    => $reservation->customer_id,
          'reservation_id' => $reservation->id,
        ];
        self::updateWallet($data);
        $reservation->update([
          'partial_payment_info->status' => 'done',
          'partial_payment_info->wallet->status' => 'done',
        ]);
      }
    }
  }

  public static function handleRemainingPaymentWebHook($reservation, $eventObject)
  {

    if ($eventObject['payment_method'] == PaymentType::Card->value) {
      $reservation->update([
        'remaining_payment_info->customer_notified' => false,
        'remaining_payment_info->status' => 'done',
        'remaining_payment_info->charge_id' => $eventObject['charge_id'],
        'remaining_payment_info->payment_intent_id' => $eventObject['payment_intent_id'],

      ]);
    } elseif ($eventObject['payment_method'] == PaymentType::CardAndWallet->value) {

      $reservation->update([
        'remaining_payment_info->customer_notified' => false,
        'remaining_payment_info->card->status'   => 'done',
        'remaining_payment_info->card->charge_id' => $eventObject['charge_id'],
        'remaining_payment_info->card->payment_intent_id' => $eventObject['payment_intent_id'],
      ]);
      $description = " خصم قيمة الدفع  المتبقي للحجز رقم  " . $reservation->id;
      $amount = $reservation->remaining_payment_info[PaymentType::Wallet->value]['amount'];
      if ($reservation->customer->wallet >= $amount) {
        $data = [
          'type'           => 'debit',
          'description'    => $description,
          'amount'         => $amount,
          'customer_id'    => $reservation->customer_id,
          'reservation_id' => $reservation->id,
        ];
        self::updateWallet($data);
        $reservation->update([
          'remaining_payment_info->status' => 'done',
          'remaining_payment_info->wallet->status' => 'done',
        ]);
      }
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
   * ex: if current payment status is succeeded then refunded we need to notify customer with that reservation is refunded
   * @param Reservation $reservation
   * @return void
   **/
  public static function makeReservationNotNotified(Reservation $reservation)
  {
    $reservation->update(['notification_is_sent' => false]);
  }

  public static function getReservationsWillNotified()
  {
    return Reservation::with(['school', 'customer', 'child'])->where('notification_is_sent', false)->whereNotNull('payment_intent_id')->get();
  }

  public static function getPaymentStatus($event)
  {
    $status = [
      'payment_intent.succeeded' =>  PaymentStatus::Succeeded->value,
      'payment_intent.payment_failed'    =>  PaymentStatus::Failed->value,
    ];
    return $status[$event] ?? null;
  }

  public static function getSucceededPartialPaymentReservations()
  {
    return Reservation::with(['school', 'customer', 'child'])->where('partial_payment_info->status', 'done')->where('partial_payment_info->customer_notified', false)->get();
  }

  public static function getFailedPartialPaymentReservations()
  {
    return Reservation::with(['school', 'customer', 'child'])->where('payment_notification->type', PaymentStep::PartialPayment->value)->where('payment_notification->customer_notified', false)->get();
  }

  public static function getSucceededRemainingPaymentReservations()
  {
    return Reservation::with(['school', 'customer', 'child'])->where('remaining_payment_info->status', 'done')->where('remaining_payment_info->customer_notified', false)->get();
  }

  public static function getFailedRemainingPaymentReservations()
  {
    return Reservation::with(['school', 'customer', 'child'])->where('payment_notification->type', PaymentStep::RemainingPayment->value)->where('payment_notification->customer_notified', false)->get();
  }

  public static function getRefundedPartialPaymentReservations()
  {
    return Reservation::with(['school', 'customer', 'child'])->where('payment_notification->type', 'charge.refunded')->where('payment_notification->customer_notified', false)->get();
  }
}
