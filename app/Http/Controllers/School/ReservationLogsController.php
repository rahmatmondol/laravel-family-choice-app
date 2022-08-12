<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use App\Http\Controllers\School\BaseController;
use App\Interfaces\ReservationLogRepositoryInterface;

class ReservationLogsController extends BaseController
{
  public function __construct(private ReservationLogRepositoryInterface $reservationLogRepository )
  {
    parent::__construct();
  } //end of constructor

  public function index(Request $request)
  {
    $logs = $this->reservationLogRepository->getFilteredReservationLogs($request);

    session(['currentPage' => request('page', 1)]);

    return view($this->mainViewPrefix . '.reservation-logs.index', compact('logs'));
  } // end of index

}//end of controller
