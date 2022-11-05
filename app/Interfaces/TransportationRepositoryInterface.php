<?php

namespace App\Interfaces;

interface TransportationRepositoryInterface
{
  public function getFilteredTransportations($request);
  public function getTransportations($request);
  public function getTransportationById($transportationId);
  public function createTransportation($request);
  public function updateTransportation($request, $transportation);
  public function deleteTransportation($transportation);
}
