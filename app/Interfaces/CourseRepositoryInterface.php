<?php

namespace App\Interfaces;

interface CourseRepositoryInterface
{
  public function getFilteredCourses($request);
  public function getCourseById($courseId);
  public function createCourse($request);
  public function updateCourse($request, $course);
  public function deleteCourse($course);
}
