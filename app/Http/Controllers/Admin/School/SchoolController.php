<?php

namespace App\Http\Controllers\Admin\School;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SchoolTypeRepository;
use App\Interfaces\TypeRepositoryInterface;
use App\Interfaces\GradeRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Repositories\EducationTypeRepository;
use App\Http\Requests\Admin\SchoolFormRequest;
use App\Interfaces\ServiceRepositoryInterface;
use App\Repositories\EducationalSubjectRepository;

class SchoolController extends Controller
{

  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
    private EducationalSubjectRepository $educationalSubjectRepository,
    private EducationTypeRepository $educationTypeRepository,
    private SchoolTypeRepository $schoolTypeRepository,
    private GradeRepositoryInterface $gradeRepository,
    private TypeRepositoryInterface $typeRepository,
    private ServiceRepositoryInterface $serviceRepository,
  ) {
    // create read update delete
    $this->middleware(['permission:read_schools'])->only('index');
    $this->middleware(['permission:create_schools'])->only('create');
    $this->middleware(['permission:update_schools'])->only('edit');
    $this->middleware(['permission:delete_schools'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $schools = $this->schoolRepository->getFilteredSchools($request);

    return view('admin.schools.index', compact('schools'));
  } // end of index

  public function create(Request $request)
  {
    $educationalSubjects = $this->educationalSubjectRepository->getAllEducationalSubjects();
    $educationTypes = $this->educationTypeRepository->getAllEducationTypes();
    $schoolTypes = $this->schoolTypeRepository->getAllSchoolTypes();
    $grades = $this->gradeRepository->getAllGrades();
    $types = $this->typeRepository->getAllTypes();
    $services = $this->serviceRepository->getAllServices();

    return view('admin.schools.create', compact('educationalSubjects', 'educationTypes', 'schoolTypes', 'grades', 'types','services'));
  } //end of create

  public function show($school)
  {
    $school = $this->schoolRepository->getSchoolById($school);

    return view('admin.schools.show', compact('school'));
  } //end of create

  public function store(SchoolFormRequest $request)
  {
    $this->schoolRepository->createSchool($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.schools.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($school)
  {
    $educationalSubjects = $this->educationalSubjectRepository->getAllEducationalSubjects();
    $educationTypes = $this->educationTypeRepository->getAllEducationTypes();
    $schoolTypes = $this->schoolTypeRepository->getAllSchoolTypes();
    $grades = $this->gradeRepository->getAllGrades();
    $types = $this->typeRepository->getAllTypes();
    $services = $this->serviceRepository->getAllServices();


    $school = $this->schoolRepository->getSchoolById($school);
    return view('admin.schools.edit', compact('school', 'educationalSubjects', 'educationTypes', 'schoolTypes', 'grades', 'types','services'));
  } //end of edit

  public function update(SchoolFormRequest $request, School $school)
  {
    $this->schoolRepository->updateSchool($request, $school);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.schools.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(School $school)
  {
    if (!$school) {
      return redirect()->back();
    }
    $this->schoolRepository->deleteSchool($school);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($mainRoutePrefix.'.schools.index', ['page' => session('currentPage')]);
  } //end of destroy

  public function deleteImage($id)
  {
    $this->schoolRepository->deleteAttachment($id);
    session()->flash('success', __('Data deleted successfully'));
    return redirect()->back();
  }
}//end of controller
