<?php

namespace App\Interfaces\Customer;

interface ReservationRepositoryInterface
{
  public function addReservation($request);
  public function updateReservation($request);
  public function customerReservations();
  public function reservationDetails($reservationId);
}
