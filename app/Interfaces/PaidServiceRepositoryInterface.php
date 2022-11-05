<?php

namespace App\Interfaces;

interface PaidServiceRepositoryInterface
{
  public function getFilteredPaidServices($request);
  public function getPaidServices($request);
  public function getPaidServiceById($paidServiceId);
  public function createPaidService($request);
  public function updatePaidService($request, $paidService);
  public function deletePaidService($paidService);
}
