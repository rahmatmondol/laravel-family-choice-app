<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\ReservationLogRepositoryInterface;

class ReservationLogsController extends BaseController
{
  public function __construct(private ReservationLogRepositoryInterface $reservationLogRepository )
  {
    parent::__construct();
    $this->middleware(['permission:read_reservations'])->only('index');
    $this->middleware(['permission:create_reservations'])->only('create');
    $this->middleware(['permission:update_reservations'])->only('edit');
    $this->middleware(['permission:delete_reservations'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {

    $logs = $this->reservationLogRepository->getFilteredReservationLogs($request);

    session(['currentPage' => request('page', 1)]);

    return view($this->mainViewPrefix . '.reservation-logs.index', compact('logs'));
  } // end of index

}//end of controller
