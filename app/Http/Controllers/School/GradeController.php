<?php

namespace App\Http\Controllers\School;

use App\Models\Grade;
use App\Models\School;
use App\Models\SchoolGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\School\SchoolGradeService;
use App\Interfaces\GradeRepositoryInterface;
use App\Http\Requests\Admin\GradeFormRequest;
use App\Http\Controllers\School\BaseController;
use App\Http\Requests\Admin\SchoolGradeFormRequest;

class GradeController extends BaseController
{
  public function __construct(
    private GradeRepositoryInterface $gradeRepository
  ) {
    parent::__construct();
  } //end of constructor

  public function index(Request $request)
  {
    $grades = SchoolGradeService::getSchoolGrades($this->globalSchool);
    return view($this->mainViewPrefix . '.grades.index', compact( 'grades'));
  } // end of index

  public function create(Request $request)
  {
    $grades = $this->gradeRepository->getAllGrades();
    $school = $this->globalSchool;
    return view($this->mainViewPrefix . '.grades.create', compact('school', 'grades'));
  } //end of create

  public function show(Grade $grade)
  {
    $schoolGrade = SchoolGradeService::getSchoolGrade($this->globalSchool, $grade);
    return view($this->mainViewPrefix . '.grades.show', compact('schoolGrade'));
  } //end of create

  public function store(SchoolGradeFormRequest $request)
  {
    SchoolGradeService::storeSchoolGrade($request,$this->globalSchool->id);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix . '.grades.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(Grade $grade)
  {
    $grades = $this->gradeRepository->getAllGrades();

    $schoolGrade = SchoolGradeService::getSchoolGrade($this->globalSchool, $grade);
    $school = $this->globalSchool;
    return view($this->mainViewPrefix . '.grades.edit', compact('grades', 'schoolGrade', 'school'));
  } //end of edit

  public function update(SchoolGradeFormRequest $request, Grade $grade)
  {
    SchoolGradeService::updateSchoolGrade($request,$this->globalSchool,$grade);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix . '.grades.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Grade $grade)
  {
    if (!$grade) {
      return redirect()->back();
    }
    SchoolGradeService::deleteSchoolGrade($this->globalSchool,$grade);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix . '.grades.index', ['page' => session('currentPage')]);

  } //end of destroy

}//end of controller
