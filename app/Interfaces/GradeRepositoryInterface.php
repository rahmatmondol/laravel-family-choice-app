<?php

namespace App\Interfaces;

interface GradeRepositoryInterface
{
  public function getAllGrades();
  public function getFilteredGrades($request);
  public function getGradeById($gradId);
  public function createGrade($request);
  public function updateGrade($request, $grad);
  public function deleteGrade($grad);
}
