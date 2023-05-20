<?php

namespace App\Repositories\Customer;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Interfaces\Customer\WalletRepositoryInterface;
use App\Models\Reservation;
use App\Traits\Customer\WalletTrait;
use App\Traits\UploadFileTrait;

class WalletRepository implements WalletRepositoryInterface
{
  use UploadFileTrait, WalletTrait;

  #addReservation
  public function paymentWithWallet($request)
  {
    $reservation = Reservation::find($request->reservation_id);
    if ($reservation->required_payment_step_is_partial) {
      self::handlePayPartialPayment($reservation);
    } else {
      self::handlePayRemainingPayment($reservation);
    }
    //TODO MAM: send mail confirmation
    return $reservation->refresh();
  }
  public static function handlePayPartialPayment($reservation)
  {
    $partial_payment_info = [
      'status' => 'done',
      'type' => PaymentType::Wallet->value,
      'amount' => $reservation->required_partial_payment_amount,
      'customer_notified'=>false,
    ];

    $description = " خصم قيمة الدفع  المقدم للحجز رقم  " . $reservation->id;
    $data = [
      'type'           => 'debit',
      'description'    => $description,
      'amount'         => $reservation->required_partial_payment_amount,
      'customer_id'    => $reservation->customer_id,
      'reservation_id' => $reservation->id,
    ];
    self::updateWallet($data);

    $reservation->update([
      'partial_payment_info' => $partial_payment_info,
      // 'partial_payment_info->customer_notified' => false,
    ]);
    // return $reservation;
  }
  public static function handlePayRemainingPayment($reservation)
  {
    $remaining_payment_info = [
      'status' => 'done',
      'type' => PaymentType::Wallet->value,
      'amount' => $reservation->required_remaining_payment_amount,
      'customer_notified'=>false,
      'payment_status'=>PaymentStatus::Succeeded->value,
    ];
    $description = " خصم قيمة الدفع  المتبقي للحجز رقم  " . $reservation->id;
    $data = [
      'type'           => 'debit',
      'description'    => $description,
      'amount'         => $reservation->required_remaining_payment_amount,
      'customer_id'    => $reservation->customer_id,
      'reservation_id' => $reservation->id,
    ];
    self::updateWallet($data);

    $reservation->update([
      'remaining_payment_info' => $remaining_payment_info,
      // 'remaining_payment_info->customer_notified' => false,
      // 'payment_status' => PaymentStatus::Succeeded->value,

    ]);
  }
}
