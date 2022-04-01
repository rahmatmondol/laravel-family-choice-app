<?php

namespace App\Interfaces;

interface SchoolTypeRepositoryInterface
{
  public function getAllSchoolTypes();
  public function getFilteredSchoolTypes($request);
  public function getSchoolTypeById($schoolTypeId);
  public function createSchoolType($request);
  public function updateSchoolType($request, $schoolType);
  public function deleteSchoolType($schoolType);
}
