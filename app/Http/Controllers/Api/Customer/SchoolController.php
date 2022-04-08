<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Resources\Collection\CourseCollection;
use App\Http\Resources\Collection\SchoolCollection;

class SchoolController extends Controller
{
  use ResponseTrait;

  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
    private CourseRepositoryInterface $courseRepository,
  ) {
  } //end of constructor

  public function schools(Request $request)
  {
    // dd($request->all());
    $schools = $this->schoolRepository->getSchools($request);
    return $this->sendResponse(new SchoolCollection($schools), "");
  }

  public function courses(Request $request)
  {
    $courses = $this->courseRepository->getCourses($request);
    return $this->sendResponse(new CourseCollection($courses), "");
  }
}
