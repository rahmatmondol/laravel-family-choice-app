<?php

namespace App\Traits\Customer;

use App\Models\Customer;
use App\Models\WalletHistory;
use Exception;

trait WalletTrait
{
  public static function updateWallet($data)
  {
    try {
      $customer =  Customer::find($data['customer_id']);
      if ($data['type'] == 'debit') {
        $customer->decrement('wallet', $data['amount']);
      }
      if ($data['type'] == 'credit') {
        $customer->increment('wallet', $data['amount']);
      }
      $customer->refresh();
      WalletHistory::create([
        'type'            => $data['type'],
        'amount'          => $data['amount'],
        'current_wallet'  => $customer->wallet,
        'description'     => $data['description'],
        'customer_id'     => $data['customer_id'],
        'reservation_id'  => $data['reservation_id'],
      ]);
      //TODO MAM: send mail notification
    } catch (Exception $e) {
      info($e->getMessage());
    }
  }
}
