<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Interfaces\ReservationRepositoryInterface;

class ReservationExport implements FromView
{
  public function __construct(private $reservationRepository,private $view='admin')
  {
  }
  
  public function view(): View
  {
    $reservations = $this->reservationRepository->getFilteredReservations(request());
    return view($this->view.'.reservations.exports', [
      'reservations' => $reservations,
    ]);
  }
}
