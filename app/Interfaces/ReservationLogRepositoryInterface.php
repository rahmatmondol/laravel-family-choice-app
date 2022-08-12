<?php

namespace App\Interfaces;

interface ReservationLogRepositoryInterface
{
  public function getFilteredReservationLogs($request);
}
