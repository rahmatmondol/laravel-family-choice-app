<?php

namespace App\Interfaces;

interface ReservationRepositoryInterface
{
  public function getFilteredReservations($request);
  public function getReservationById($reservationId);
  public function updateReservation($request, $reservation);
  public function deleteReservation($reservation);
}
