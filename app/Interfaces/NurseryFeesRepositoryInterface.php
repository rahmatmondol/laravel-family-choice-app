<?php

namespace App\Interfaces;

interface NurseryFeesRepositoryInterface
{
  public function getFilteredNurseryFees($request);
  public function getNurseryFees($request);
  public function getNurseryFeesById($nurseryFeesId);
  public function createNurseryFees($request);
  public function updateNurseryFees($request, $nurseryFees);
  public function deleteNurseryFees($nurseryFees);
}
