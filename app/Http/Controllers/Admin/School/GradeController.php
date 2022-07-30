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

class GradeController extends BaseController
{

  // use GradeTrait, PermissionTrait;

  public function __construct(
    private GradeRepositoryInterface $gradeRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_grades'])->only('index');
    $this->middleware(['permission:create_grades'])->only('create');
    $this->middleware(['permission:update_grades'])->only('edit');
    $this->middleware(['permission:delete_grades'])->only('destroy');
  } //end of constructor

  public function index(Request $request, School $school)
  {
    $grades = $school->grades;
    // dd($grades);
    return view('admin.schools.grades.index', compact('school', 'grades'));
  } // end of index

  public function create(Request $request, School $school)
  {
    $grades = $this->gradeRepository->getAllGrades();
    return view('admin.schools.grades.create', compact('school', 'grades'));
  } //end of create

  public function show(School $school, Grade $grade)
  {
    $schoolGrade = SchoolGrade::where([['school_id', $school->id], ['grade_id', $grade->id]])->first();
    // dd($schoolGrade->school);
    return view('admin.schools.grades.show', compact('schoolGrade'));
  } //end of create

  public function store(SchoolGradeFormRequest $request, School $school)
  {
    DB::table('school_grade')->updateOrInsert(['grade_id' => $request->grade_id, 'school_id' => $request->school_id], [
      'fees' => $request->fees,
      'administrative_expenses' => $request->administrative_expenses,
      'status' => $request->status
    ]);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.schools.grades.index', ['school' => $school->id, 'page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(School $school, Grade $grade)
  {
    $grades = $this->gradeRepository->getAllGrades();

    // $grade = $this->gradeRepository->getGradeById($grade->id);
    $schoolGrade  = SchoolGrade::where('grade_id', $grade->id)->where('school_id', $school->id)->first();
    return view('admin.schools.grades.edit', compact('grades', 'schoolGrade', 'school'));
  } //end of edit

  public function update(SchoolGradeFormRequest $request, School $school, Grade $grade)
  {
    DB::table('school_grade')->updateOrInsert(['grade_id' => $grade->id, 'school_id' => $school->id], [
      'fees' => $request->fees,
      'administrative_expenses' => $request->administrative_expenses,
      'status' => $request->status
    ]);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.schools.grades.index', ['school' => $school->id, 'page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Grade $grade)
  {
    if (!$grade) {
      return redirect()->back();
    }
    $this->gradeRepository->deleteGrade($grade);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.grades.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
