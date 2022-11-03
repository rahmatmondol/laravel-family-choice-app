<?php

namespace App\Http\Controllers\Admin\School;

use App\Models\Grade;
use App\Models\School;
use App\Models\SchoolGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\GradeRepositoryInterface;
use App\Http\Requests\Admin\GradeFormRequest;
use App\Http\Requests\Admin\SchoolGradeFormRequest;
use App\Services\School\SchoolGradeService;

class GradeController extends BaseController
{

  // use GradeTrait, PermissionTrait;

  public function __construct(
    private GradeRepositoryInterface $gradeRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_grades'])->only('index');
    $this->middleware(['permission:create_grades'])->only('create');
    $this->middleware(['permission:update_grades'])->only('edit');
    $this->middleware(['permission:delete_grades'])->only('destroy');
  } //end of constructor

  public function index(Request $request, School $school)
  {
    $grades = SchoolGradeService::getSchoolGrades($school);
    return view($this->mainViewPrefix . '.schools.grades.index', compact('school', 'grades'));
  } // end of index

  public function create(Request $request, School $school)
  {
    $grades = $this->gradeRepository->getAllGrades();
    return view($this->mainViewPrefix . '.schools.grades.create', compact('school', 'grades'));
  } //end of create

  public function show(School $school, Grade $grade)
  {
    $schoolGrade = SchoolGradeService::getSchoolGrade($school, $grade);
    return view($this->mainViewPrefix . '.schools.grades.show', compact('schoolGrade'));
  } //end of create

  public function store(SchoolGradeFormRequest $request, School $school)
  {
    SchoolGradeService::storeSchoolGrade($request,$request->school_id);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix . '.schools.grades.index', ['school' => $school->id, 'page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(School $school, Grade $grade)
  {
    $grades = $this->gradeRepository->getAllGrades();

    $schoolGrade = SchoolGradeService::getSchoolGrade($school, $grade);

    return view($this->mainViewPrefix . '.schools.grades.edit', compact('grades', 'schoolGrade', 'school'));
  } //end of edit

  public function update(SchoolGradeFormRequest $request, School $school, Grade $grade)
  {
    SchoolGradeService::updateSchoolGrade($request,$school,$grade);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix . '.schools.grades.index', ['school' => $school->id, 'page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(School $school,Grade $grade)
  {
    if (!$grade) {
      return redirect()->back();
    }
    SchoolGradeService::deleteSchoolGrade($school,$grade);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix . '.schools.grades.index', ['school' => $school->id, 'page' => session('currentPage')]);

  } //end of destroy

}//end of controller
