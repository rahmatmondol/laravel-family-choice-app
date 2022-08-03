<?php

namespace App\Http\Controllers\School;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\SchoolTypeRepository;
use App\Interfaces\TypeRepositoryInterface;
use App\Interfaces\GradeRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Repositories\EducationTypeRepository;
use App\Http\Requests\Admin\SchoolFormRequest;
use App\Interfaces\ServiceRepositoryInterface;
use App\Http\Controllers\School\BaseController;
use App\Http\Requests\School\ChangePasswordFormRequest;
use App\Repositories\EducationalSubjectRepository;

class ProfileController extends BaseController
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
    parent::__construct();
  } //end of constructor

  public function show()
  {
    $school = $this->schoolRepository->getSchoolById($this->globalSchool);

    return view($this->mainViewPrefix . '.profile.show', compact('school'));
  } //end of create

  public function edit()
  {
    $educationalSubjects = $this->educationalSubjectRepository->getAllEducationalSubjects();
    $educationTypes = $this->educationTypeRepository->getAllEducationTypes();
    $schoolTypes = $this->schoolTypeRepository->getAllSchoolTypes();
    $grades = $this->gradeRepository->getAllGrades();
    $types = $this->typeRepository->getAllTypes();
    $services = $this->serviceRepository->getAllServices();

    $school = $this->schoolRepository->getSchoolById($this->globalSchool);
    return view($this->mainViewPrefix . '.profile.edit', compact('school', 'educationalSubjects', 'educationTypes', 'schoolTypes', 'grades', 'types', 'services'));
  } //end of edit

  public function update(SchoolFormRequest $request)
  {
    $this->schoolRepository->updateSchool($request, $this->globalSchool);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix . '.profile.show');
    }
    return redirect()->back();
  } //end of update

  public function deleteImage($id)
  {
    $this->schoolRepository->deleteAttachment($id);
    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->back();
  }
  public function changePassword()
  {
    return view('school.profile.change-password');
  }

  public function changePasswordPost(ChangePasswordFormRequest $request)
  {
    $this->globalSchool->password = bcrypt($request->password);
    $this->globalSchool->save();

    return redirect()->back()->with("success", __('site.Password successfully changed!'));
  }
}
