<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\RoleRepositoryInterface;
use App\Http\Requests\Admin\RoleFormRequest;
use App\Http\Controllers\Admin\BaseController;

class RoleController extends BaseController
{

  // use RoleTrait, PermissionTrait;

  public function __construct(private RoleRepositoryInterface $roleRepository)
  {
    //create read update delete
    $this->middleware(['permission:read_roles'])->only('index');
    $this->middleware(['permission:create_roles'])->only('create');
    $this->middleware(['permission:update_roles'])->only('edit');
    $this->middleware(['permission:delete_roles'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $roles = $this->roleRepository->getFilteredRoles($request);

    return view('admin.roles.index', compact('roles'));
  } // end of index

  public function create(Request $request)
  {

    return view('admin.roles.create');
  } //end of create

  public function show($role)
  {
    $role = $this->roleRepository->getRoleById($role);

    return view('admin.roles.show', compact('role'));
  } //end of create

  public function store(RoleFormRequest $request)
  {
    $this->roleRepository->createRole($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.roles.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(Role $role)
  {

    $role = $role->load('permissions');

    // dd($role);
    return view('admin.roles.edit', compact('role'));
  } //end of edit

  public function update(RoleFormRequest $request, Role $role)
  {
    $this->roleRepository->updateRole($request, $role);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.roles.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Role $role)
  {
    if (!$role) {
      return redirect()->back();
    }
    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($mainRoutePrefix.'.roles.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
