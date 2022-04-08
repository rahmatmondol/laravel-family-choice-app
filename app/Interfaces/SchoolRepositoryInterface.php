<?php

namespace App\Interfaces;

interface SchoolRepositoryInterface
{
  public function getAllSchools();
  public function getFilteredSchools($request);
  public function getSchools($request);
  public function getSchoolById($schoolId);
  public function createSchool($request);
  public function updateSchool($request, $school);
  public function deleteSchool($school);
  public function deleteAttachment($id);
}
