<?php

namespace App\Interfaces;

interface SchoolRepositoryInterface
{
  public function getFilteredSchools($request);
  public function getSchoolById($schoolId);
  public function createSchool($request);
  public function updateSchool($request, $school);
  public function deleteSchool($school);
}
