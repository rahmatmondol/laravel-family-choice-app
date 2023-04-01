<?php

namespace App\Services\Reservation;

use App\Enums\PaymentType;
use App\Models\Reservation;
use App\Traits\Customer\WalletTrait;

class RefundPartialPaymentService
{
  use WalletTrait;
  public static function refundPartialPayment($id)
  {
    $reservation = Reservation::findOrFail($id);
    if ($info = $reservation->partial_payment_info) {
      if ($info['type'] == PaymentType::Wallet->value) {
        self::refundInWallet($reservation);
      }
      if ($info['type'] == PaymentType::Card->value) {
        self::refundInCard($reservation);
      }
      if ($info['type'] == PaymentType::CardAndWallet->value) {
        self::refundInCardAndWallet($reservation);
      }
    }
    return $reservation->refresh();
  }
  public static function refundInWallet($reservation)
  {
    $description = " رد قيمة الدفع  المقدم للحجز رقم  " . $reservation->id;
    $amount = $reservation->partial_payment_info['amount'];
    $data = [
      'type'           => 'credit',
      'description'    => $description,
      'amount'         => $amount,
      'customer_id'    => $reservation->customer_id,
      'reservation_id' => $reservation->id,
    ];
    self::updateWallet($data);
    $reservation->update([
      'refund_partial_payment_info->status'    => 'done',
      'refund_partial_payment_info->type'      => PaymentType::Wallet->value,
      'refund_partial_payment_info->amount'    => $amount,
    ]);
  }
  public static function refundInCard($reservation)
  {
    $info = $reservation->partial_payment_info;
    if (isset($info) && $info['status'] == 'done' && isset($info['charge_id'])) {
      $stripe = new \Stripe\StripeClient(
        env('STRIPE_SECRET')
      );
      $result  = $stripe->refunds->create([
        'charge' => $info['charge_id'],
      ]);
      if (isset($result['status']) && $result['status'] == 'succeeded') {
        $reservation->update([
          'refund_partial_payment_info->status'    => 'done',
          'refund_partial_payment_info->type'      => PaymentType::Card->value,
          'refund_partial_payment_info->amount'    => $reservation->amount_refunded_to_card_in_partial_payment,
        ]);
      }
    }
  }
  public static function refundInCardAndWallet($reservation)
  {
    $info = $reservation->partial_payment_info;
    // dd($info);
    if (isset($info) && $info['status'] == 'done' && isset($info['card']['charge_id'])) {
      $stripe = new \Stripe\StripeClient(
        env('STRIPE_SECRET')
      );
      $result  = $stripe->refunds->create([
        'charge' => $info['card']['charge_id'],
      ]);
      if (isset($result['status']) && $result['status'] == 'succeeded') {
        $reservation->update([
          'refund_partial_payment_info->type'      => PaymentType::CardAndWallet->value,
          'refund_partial_payment_info->card->status'    => 'done',
          'refund_partial_payment_info->card->amount'    => $reservation->amount_refunded_to_card_in_partial_payment,
        ]);
        // if refund in card is done continue refunding in wallet
        $description = " رد قيمة الدفع  المقدم للحجز رقم  " . $reservation->id;
        $amount = $reservation->partial_payment_info['wallet']['amount'];
        $data = [
          'type'           => 'credit',
          'description'    => $description,
          'amount'         => $amount,
          'customer_id'    => $reservation->customer_id,
          'reservation_id' => $reservation->id,
        ];
        self::updateWallet($data);
        $reservation->update([
          'refund_partial_payment_info->status'            => 'done',
          'refund_partial_payment_info->wallet->status'    => 'done',
          'refund_partial_payment_info->wallet->amount'    => $amount,
        ]);
      }
    }
  }
}
