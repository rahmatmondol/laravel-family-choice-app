<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\School;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Resources\Collection\CourseCollection;
use App\Http\Resources\Collection\ReviewCollection;
use App\Http\Resources\Collection\SchoolCollection;

class SchoolController extends BaseController
{
  use ResponseTrait;

  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
    private CourseRepositoryInterface $courseRepository,
  ) {
  } //end of constructor

  public function schools(Request $request)
  {
    $schools = $this->schoolRepository->getSchools($request);
    return $this->sendResponse(new SchoolCollection($schools), "");
  }

  public function courses(Request $request)
  {
    $courses = $this->courseRepository->getCourses($request);
    return $this->sendResponse(new CourseCollection($courses), "");
  }

  public function school_reviews(Request $request)
  {
    $school = School::findOrFail($request->school_id);
    $reviews = $this->schoolRepository->schoolReviews($school);
    return $this->sendResponse(new ReviewCollection($reviews), "");
  }
}
