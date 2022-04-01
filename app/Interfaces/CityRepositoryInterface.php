<?php

namespace App\Interfaces;

interface CityRepositoryInterface
{
  public function getFilteredCities($request);
  public function getAllCities();
  public function getCityById($cityId);
  public function createCity($request);
  public function updateCity($request, $city);
  public function deleteCity($city);
}
