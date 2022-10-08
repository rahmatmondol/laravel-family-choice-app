<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PaymentExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\SchoolRepositoryInterface;
use App\Services\Payment\PaymentService;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends BaseController
{


  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
  ) {
    parent::__construct();
    $this->middleware(['permission:read_reservations'])->only('index');
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
