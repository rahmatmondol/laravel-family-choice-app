<?php

namespace App\Interfaces;

interface EducationTypeRepositoryInterface
{
  public function getAllEducationTypes();
  public function getFilteredEducationTypes($request);
  public function getEducationTypeById($educationTypeId);
  public function createEducationType($request);
  public function updateEducationType($request, $educationType);
  public function deleteEducationType($educationType);
}
