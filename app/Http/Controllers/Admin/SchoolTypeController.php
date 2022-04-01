<?php

namespace App\Http\Controllers\Admin;

use App\Models\SchoolType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\SchoolTypeRepositoryInterface;
use App\Http\Requests\Admin\SchoolTypeFormRequest;

class SchoolTypeController extends Controller
{

  // use SchoolTypeTrait, PermissionTrait;

  public function __construct(
    private SchoolTypeRepositoryInterface $schoolTypeRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_schoolTypes'])->only('index');
    $this->middleware(['permission:create_schoolTypes'])->only('create');
    $this->middleware(['permission:update_schoolTypes'])->only('edit');
    $this->middleware(['permission:delete_schoolTypes'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $schoolTypes = $this->schoolTypeRepository->getFilteredSchoolTypes($request);

    return view('admin.schoolTypes.index', compact('schoolTypes'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view('admin.schoolTypes.create', compact('roles'));
  } //end of create

  public function show($schoolType)
  {
    $schoolType = $this->schoolTypeRepository->getSchoolTypeById($schoolType);

    return view('admin.schoolTypes.show', compact('schoolType'));
  } //end of create

  public function store(SchoolTypeFormRequest $request)
  {
    $this->schoolTypeRepository->createSchoolType($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route('admin.schoolTypes.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($schoolType)
  {

    $schoolType = $this->schoolTypeRepository->getSchoolTypeById($schoolType);

    // $roles = $this->roleRepository->getAllRoles();

    return view('admin.schoolTypes.edit', compact('schoolType',));
  } //end of edit

  public function update(SchoolTypeFormRequest $request, SchoolType $schoolType)
  {
    $this->schoolTypeRepository->updateSchoolType($request, $schoolType);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route('admin.schoolTypes.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(SchoolType $schoolType)
  {
    if (!$schoolType) {
      return redirect()->back();
    }
    $this->schoolTypeRepository->deleteSchoolType($schoolType);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route('admin.schoolTypes.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
