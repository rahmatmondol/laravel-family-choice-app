<?php

namespace App\Interfaces;

interface TypeRepositoryInterface
{
  public function getAllTypes();
  public function getFilteredTypes($request);
  public function getTypeById($typeId);
  public function createType($request);
  public function updateType($request, $type);
  public function deleteType($type);
}
