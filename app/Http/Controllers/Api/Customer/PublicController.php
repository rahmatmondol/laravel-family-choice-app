<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Inbox;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\GradeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SchoolTypeResource;
use App\Http\Resources\StaticPageResource;
use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\GradeRepositoryInterface;
use App\Http\Resources\EducationTypeResource;
use App\Interfaces\SliderRepositoryInterface;
use App\Interfaces\SchoolTypeRepositoryInterface;
use App\Interfaces\UserManualRepositoryInterface;
use App\Http\Resources\EducationalSubjectResource;
use App\Http\Resources\Collection\SliderCollection;
use App\Http\Requests\Api\ContactSupportFormRequest;
use App\Interfaces\EducationTypeRepositoryInterface;
use App\Http\Resources\Collection\UserManualCollection;
use App\Interfaces\EducationalSubjectRepositoryInterface;

class PublicController extends Controller
{
  use ResponseTrait;

  public function __construct(
    private CityRepositoryInterface $cityRepository,
    private SliderRepositoryInterface $sliderRepository,
    private GradeRepositoryInterface $gradeRepository,
    private EducationalSubjectRepositoryInterface $educationalSubjectRepository,
    private EducationTypeRepositoryInterface $educationTypeRepository,
    private SchoolTypeRepositoryInterface $schoolTypeRepository,
    private UserManualRepositoryInterface $userManualRepository,
  ) {
  } //end of constructor

  public function filterData(Request $request)
  {
    $data = [
      'grades' =>  GradeResource::collection($this->gradeRepository->getAllGrades()),
      'educationalSubjects' => EducationalSubjectResource::collection($this->educationalSubjectRepository->getAllEducationalSubjects()),
      'educationTypes' => EducationTypeResource::collection($this->educationTypeRepository->getAllEducationTypes()),
      'schoolTypes' => SchoolTypeResource::collection($this->schoolTypeRepository->getAllSchoolTypes()),
    ];
    return $this->sendResponse($data, "");
  }

  public function cities(Request $request)
  {
    $cities = $this->cityRepository->getAllCities();

    return $this->sendResponse(CityResource::collection($cities), "");
  }

  public function sliders(Request $request)
  {
    $sliders = $this->sliderRepository->getSliders($request);

    return $this->sendResponse(new SliderCollection($sliders), "");
  }

  public function userManuals(Request $request)
  {
    $sliders = $this->userManualRepository->getUserManuals($request);

    return $this->sendResponse(new UserManualCollection($sliders), "");
  }

  public function staticPages(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'pageName' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError(' ', $validator->errors());
    }

    $page = Page::where('pageName', $request->pageName)->firstOrFail();

    return $this->sendResponse(new StaticPageResource($page), "");
  }

  public function contactSupport(ContactSupportFormRequest $request)
  {
    Inbox::create([
      'full_name' => $request->full_name,
      'problem_title' => $request->problem_title,
      'message' => $request->message,
    ]);
    return $this->sendResponse("", "");
  }
}
