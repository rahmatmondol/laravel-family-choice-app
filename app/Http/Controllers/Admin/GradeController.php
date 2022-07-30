<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\GradeRepositoryInterface;
use App\Http\Requests\Admin\GradeFormRequest;
use App\Http\Controllers\Admin\BaseController;

class GradeController extends BaseController
{

  // use GradeTrait, PermissionTrait;

  public function __construct(
    private GradeRepositoryInterface $gradeRepository
  ) {

    parent::__construct();
    // dd('in in controller',$this->globalAdmin,$this->masterLayout);
    //create read update delete
    $this->middleware(['permission:read_grades'])->only('index');
    $this->middleware(['permission:create_grades'])->only('create');
    $this->middleware(['permission:update_grades'])->only('edit');
    $this->middleware(['permission:delete_grades'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $grades = $this->gradeRepository->getFilteredGrades($request);

    return view($this->mainViewPrefix.'.grades.index', compact('grades'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view($this->mainViewPrefix.'.grades.create', compact('roles'));
  } //end of create

  public function show($grade)
  {
    $grade = $this->gradeRepository->getGradeById($grade);

    return view($this->mainViewPrefix.'.grades.show', compact('grade'));
  } //end of create

  public function store(GradeFormRequest $request)
  {
    $this->gradeRepository->createGrade($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.grades.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($grade)
  {

    $grade = $this->gradeRepository->getGradeById($grade);

    // $roles = $this->roleRepository->getAllRoles();

    return view($this->mainViewPrefix.'.grades.edit', compact('grade',));
  } //end of edit

  public function update(GradeFormRequest $request, Grade $grade)
  {
    $this->gradeRepository->updateGrade($request, $grade);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.grades.index', ['page' => session('currentPage')]);
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
