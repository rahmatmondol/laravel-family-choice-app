<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Inbox;
use App\Models\School;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\TypeResource;
use App\Http\Resources\GradeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SchoolTypeResource;
use App\Http\Resources\StaticPageResource;
use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\TypeRepositoryInterface;
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
use App\Http\Resources\SliderResource;
use App\Http\Resources\SubscriptionResource;
use App\Interfaces\EducationalSubjectRepositoryInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\GradeFees;
use App\Models\NurseryFees;

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
    private TypeRepositoryInterface $typeRepository,
    private SubscriptionRepositoryInterface $subscriptionRepository,
  ) {
  } //end of constructor

  public function filterData(Request $request)
  {
    $data = [
      'subscriptions' =>  SubscriptionResource::collection($this->subscriptionRepository->getAllSubscriptions()),
      'grades' =>  GradeResource::collection($this->gradeRepository->getAllGrades()),
      'educationalSubjects' => EducationalSubjectResource::collection($this->educationalSubjectRepository->getAllEducationalSubjects()),
      'educationTypes' => EducationTypeResource::collection($this->educationTypeRepository->getAllEducationTypes()),
      'schoolTypes' => SchoolTypeResource::collection($this->schoolTypeRepository->getAllSchoolTypes()),
      'max_fees' => GradeFees::max('price'),
      'min_fees' => NurseryFees::min('price'),
    ];
    return $this->sendResponse($data, "");
  }

  public function types(Request $request)
  {
    $types = $this->typeRepository->getAllTypes();

    return $this->sendResponse(TypeResource::collection($types), "");
  }

  public function cities(Request $request)
  {
    $cities = $this->cityRepository->getAllCities();

    return $this->sendResponse(CityResource::collection($cities), "");
  }

  public function sliders(Request $request)
  {
    $sliders = $this->sliderRepository->getSliders($request);

    return $this->sendResponse(SliderResource::collection($sliders), "");
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

  public function configData(Request $request)
  {
    $config = [
      'partial_payment_percent'=>setting('partial_payment_percent'),
      'refund_fees_percent'=>setting('refund_fees_percent'),
    ];
    return $this->sendResponse($config, "");
  }
}
