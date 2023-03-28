<?php

namespace App\Services\Reservation;

use App\Enums\PaymentStatus;
use App\Models\Reservation;
use App\Traits\Customer\WalletTrait;

class ReservationService
{
  use WalletTrait;
  public static function updateReservationPaymentStatus($reservation,$eventObject)
  {
    $payment_intent_id = $eventObject['payment_intent_id'];
    $event_type        = $eventObject['event_type'];

    $status  = self::getPaymentStatus($event_type);

    if ($status != $reservation->payment_status) {
      $reservation->update(['payment_status' => $status, 'payment_intent_id' => $payment_intent_id]);
      self::makeReservationNotNotified($reservation); // to handle new reservation status
    }
  }

  public static function handleWebHookPaymentMethod($reservation,$payment_method,$payment_step){
    // info($payment_method);
    // info('payment_method');
    if ( $payment_step =='partial_payment' ){
      self::handlePartialPaymentWebHook($reservation,$payment_method);
    } elseif($payment_step =='remaining_payment'){
      self::handleRemainingPaymentWebHook($reservation,$payment_method);
    }
  }

  public static function handlePartialPaymentWebHook($reservation,$payment_method){
    if( $payment_method == 'card'){
      $reservation->update([
        'partial_payment_info->status' => 'done',
      ]);
    } elseif($payment_method == 'card_and_wallet'){

      $reservation->update([
        'partial_payment_info->card->status'   => 'done',
      ]);
      $description = " خصم قيمة الدفع  المقدم للحجز رقم  " . $reservation->id;
      $amount = $reservation->partial_payment_info['wallet']['amount'];
      if ( $reservation->customer->wallet >= $amount ) {
        $data = [
          'type'           =>'debit',
          'description'    => $description,
          'amount'         => $amount,
          'customer_id'    => $reservation->customer_id,
          'reservation_id' => $reservation->id,
        ] ;
        self::updateWallet($data);
        $reservation->update([
          'partial_payment_info->status' => 'done',
          'partial_payment_info->wallet->status' => 'done',
        ]);
      }

    }
  }

  public static function handleRemainingPaymentWebHook($reservation,$payment_method){

    if( $payment_method == 'card'){
      $reservation->update([
        'remaining_payment_info->status' => 'done',
      ]);
    } elseif($payment_method == 'card_and_wallet'){

      $reservation->update([
        'remaining_payment_info->card->status'   => 'done',
      ]);
      $description = " خصم قيمة الدفع  المتبقي للحجز رقم  " . $reservation->id;
      $amount = $reservation->remaining_payment_info['wallet']['amount'];
      if ( $reservation->customer->wallet >= $amount ) {
        $data = [
          'type'           =>'debit',
          'description'    => $description,
          'amount'         => $amount,
          'customer_id'    => $reservation->customer_id,
          'reservation_id' => $reservation->id,
        ] ;
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
      'payment_intent.payment_failed'    =>  PaymentStatus::Failed->value,
    ];
    return $status[$event] ?? null;
  }
}
