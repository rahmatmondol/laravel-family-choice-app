<?php

namespace App\Interfaces\Customer;

interface WalletRepositoryInterface
{
  public function paymentWithWallet($request);
}
