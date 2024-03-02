<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\School;
use App\Models\SchoolTranslation;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Resources\Collection\CourseCollection;
use App\Http\Resources\Collection\ReviewCollection;
use App\Http\Resources\Collection\SchoolCollection;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\SubscriptionTypeResource;
use App\Interfaces\SubscriptionTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function search(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'title.max' => 'The title field must not exceed :max characters.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return validation error response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Retrieve the search query from the request
        $title = $request->input('title');
//
        try {
//
            // Search for schools with the specified title
            $ids = SchoolTranslation::where('title', 'LIKE', "%{$title}%")->pluck('school_id');
            $schools = School::whereIn('id',$ids)->paginate($request->perPage ?? 20);

//             Return the search results
            return $this->sendResponse(new SchoolCollection($schools),'');
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json(['error' => 'Failed to search schools.'], 500);
        }
    }

  public function schoolDetails(Request $request)
  {
    $school = $this->schoolRepository->getSchoolById($request->school_id);
    return $this->sendResponse(new SchoolResource($school), "");
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
