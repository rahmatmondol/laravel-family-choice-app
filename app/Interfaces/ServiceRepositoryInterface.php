<?php

namespace App\Interfaces;

interface ServiceRepositoryInterface
{
  public function getAllServices();
  public function getFilteredServices($request);
  public function getServiceById($serviceId);
  public function createService($request);
  public function updateService($request, $service);
  public function deleteService($service);
}
