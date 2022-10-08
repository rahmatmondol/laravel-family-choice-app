<?php

namespace App\Exports;

use App\Services\Payment\PaymentService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
  public function __construct(private $view='admin')
  {
  }
  public function view(): View
  {
    $payments = PaymentService::listPayments(request());

    return view($this->view.'.payments.exports', [
      'payments' => $payments,
    ]);
  }
}
