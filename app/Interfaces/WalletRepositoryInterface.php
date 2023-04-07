<?php

namespace App\Interfaces;

interface WalletRepositoryInterface
{
  public function getFilteredWallets($request);
}
