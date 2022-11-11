<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\School;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Resources\Collection\CourseCollection;
use App\Http\Resources\Collection\ReviewCollection;
use App\Http\Resources\Collection\SchoolCollection;
use App\Http\Resources\SubscriptionTypeResource;
use App\Interfaces\SubscriptionTypeRepositoryInterface;

class SchoolController extends Controller
{
  use ResponseTrait;

  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
    private CourseRepositoryInterface $courseRepository,
    private SubscriptionTypeRepositoryInterface $subscriptionTypeRepository,
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

  public function subscriptionTypes(Request $request)
  {
    $subscriptionTypes = $this->subscriptionTypeRepository->getSubscriptionTypes();
    return $this->sendResponse( SubscriptionTypeResource::collection($subscriptionTypes), "");
  }

  public function school_reviews(Request $request)
  {
    $school = School::findOrFail($request->school_id);
    $reviews = $this->schoolRepository->schoolReviews($school);
    return $this->sendResponse(new ReviewCollection($reviews), "");
  }
}
