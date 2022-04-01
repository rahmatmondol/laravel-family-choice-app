<?php

namespace App\Interfaces;

interface EducationalSubjectRepositoryInterface
{
  public function getAllEducationalSubjects();
  public function getFilteredEducationalSubjects($request);
  public function getEducationalSubjectById($educationalSubjectId);
  public function createEducationalSubject($request);
  public function updateEducationalSubject($request, $educationalSubject);
  public function deleteEducationalSubject($educationalSubject);
}
