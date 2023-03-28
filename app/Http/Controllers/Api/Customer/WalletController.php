<?php

namespace App\Http\Controllers\Api\Customer;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentWithWalletFormRequest;
use App\Http\Resources\ReservationResource;
use App\Interfaces\Customer\WalletRepositoryInterface;

class WalletController extends Controller
{
  use ResponseTrait;

  public function __construct(
    private WalletRepositoryInterface $walletRepository,
  ) {
  } //end of constructor

  public function  paymentWithWallet(PaymentWithWalletFormRequest $request)
  {
    // dd("done");
    $reservation = $this->walletRepository->paymentWithWallet($request);
    return $this->sendResponse(new ReservationResource($reservation), "");
  }
}
