<?php

namespace App\Repositories;

use App\Traits\UploadFileTrait;
use App\Interfaces\WalletRepositoryInterface;
use App\Models\WalletHistory;

class WalletRepository implements WalletRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredWallets($request)
  {
    return  WalletHistory::whenType($request->type ?? null)
      ->whenCustomer($request->customer_id ?? null)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }
}
