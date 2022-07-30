<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EducationType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\EducationTypeRepositoryInterface;
use App\Http\Requests\Admin\EducationTypeFormRequest;

class EducationTypeController extends BaseController
{

  // use EducationTypeTrait, PermissionTrait;

  public function __construct(
    private EducationTypeRepositoryInterface $educationTypeRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_educationTypes'])->only('index');
    $this->middleware(['permission:create_educationTypes'])->only('create');
    $this->middleware(['permission:update_educationTypes'])->only('edit');
    $this->middleware(['permission:delete_educationTypes'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $educationTypes = $this->educationTypeRepository->getFilteredEducationTypes($request);

    return view($this->mainViewPrefix.'.educationTypes.index', compact('educationTypes'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view($this->mainViewPrefix.'.educationTypes.create', compact('roles'));
  } //end of create

  public function show($educationType)
  {
    $educationType = $this->educationTypeRepository->getEducationTypeById($educationType);

    return view($this->mainViewPrefix.'.educationTypes.show', compact('educationType'));
  } //end of create

  public function store(EducationTypeFormRequest $request)
  {
    $this->educationTypeRepository->createEducationType($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.educationTypes.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($educationType)
  {

    $educationType = $this->educationTypeRepository->getEducationTypeById($educationType);

    // $roles = $this->roleRepository->getAllRoles();

    return view($this->mainViewPrefix.'.educationTypes.edit', compact('educationType',));
  } //end of edit

  public function update(EducationTypeFormRequest $request, EducationType $educationType)
  {
    $this->educationTypeRepository->updateEducationType($request, $educationType);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.educationTypes.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(EducationType $educationType)
  {
    if (!$educationType) {
      return redirect()->back();
    }
    $this->educationTypeRepository->deleteEducationType($educationType);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.educationTypes.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
