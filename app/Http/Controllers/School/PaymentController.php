<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use App\Exports\PaymentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Payment\PaymentService;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\School\BaseController;

class PaymentController extends BaseController
{


  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
  ) {
    parent::__construct();
  } //end of constructor

  public function index(Request $request)
  {
    $payments = PaymentService::listPayments($request);
    $schools = $this->schoolRepository->getAllSchools();

    return view($this->mainViewPrefix.'.payments.index', compact('payments','schools'));
  } // end of index

  public function export(Request $request)
  {
  return Excel::download(new PaymentExport(), 'PaymentExport.xlsx');

  } // end of index
} //end of controller
