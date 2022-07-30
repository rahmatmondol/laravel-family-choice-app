<?php

namespace App\Http\Controllers\Admin;

use App\Models\EducationalSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\EducationalSubjectRepositoryInterface;
use App\Http\Requests\Admin\EducationalSubjectFormRequest;

class EducationalSubjectController extends Controller
{

  // use EducationalSubjectTrait, PermissionTrait;

  public function __construct(
    private EducationalSubjectRepositoryInterface $educationalSubjectRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_educationalSubjects'])->only('index');
    $this->middleware(['permission:create_educationalSubjects'])->only('create');
    $this->middleware(['permission:update_educationalSubjects'])->only('edit');
    $this->middleware(['permission:delete_educationalSubjects'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $educationalSubjects = $this->educationalSubjectRepository->getFilteredEducationalSubjects($request);

    return view('admin.educationalSubjects.index', compact('educationalSubjects'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view('admin.educationalSubjects.create', compact('roles'));
  } //end of create

  public function show($educationalSubject)
  {
    $educationalSubject = $this->educationalSubjectRepository->getEducationalSubjectById($educationalSubject);

    return view('admin.educationalSubjects.show', compact('educationalSubject'));
  } //end of create

  public function store(EducationalSubjectFormRequest $request)
  {
    $this->educationalSubjectRepository->createEducationalSubject($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.educationalSubjects.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($educationalSubject)
  {

    $educationalSubject = $this->educationalSubjectRepository->getEducationalSubjectById($educationalSubject);

    // $roles = $this->roleRepository->getAllRoles();

    return view('admin.educationalSubjects.edit', compact('educationalSubject',));
  } //end of edit

  public function update(EducationalSubjectFormRequest $request, EducationalSubject $educationalSubject)
  {
    $this->educationalSubjectRepository->updateEducationalSubject($request, $educationalSubject);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.educationalSubjects.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(EducationalSubject $educationalSubject)
  {
    if (!$educationalSubject) {
      return redirect()->back();
    }
    $this->educationalSubjectRepository->deleteEducationalSubject($educationalSubject);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($mainRoutePrefix.'.educationalSubjects.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
