<?php

namespace App\Interfaces;

interface GradeFeesRepositoryInterface
{
  public function getFilteredGradeFees($request);
  public function getGradeFees($request);
  public function getGradeFeesById($gradeFeesId);
  public function createGradeFees($request);
  public function updateGradeFees($request, $gradeFees);
  public function deleteGradeFees($gradeFees);
}
