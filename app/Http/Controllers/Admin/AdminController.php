<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\AdminRepositoryInterface;
use App\Http\Requests\Admin\AdminFormRequest;
use App\Interfaces\RoleRepositoryInterface;

class AdminController extends BaseController
{

  // use AdminTrait, PermissionTrait;

  public function __construct(
    private AdminRepositoryInterface $adminRepository,
    private RoleRepositoryInterface $roleRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_admins'])->only('index');
    $this->middleware(['permission:create_admins'])->only('create');
    $this->middleware(['permission:update_admins'])->only('edit');
    $this->middleware(['permission:delete_admins'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $admins = $this->adminRepository->getFilteredAdmins($request);

    return view($this->mainViewPrefix.'.admins.index', compact('admins'));
  } // end of index

  public function create(Request $request)
  {
    $roles = $this->roleRepository->getAllRoles();
    return view($this->mainViewPrefix.'.admins.create', compact('roles'));
  } //end of create

  public function show($admin)
  {
    $admin = $this->adminRepository->getAdminById($admin);

    return view($this->mainViewPrefix.'.admins.show', compact('admin'));
  } //end of create

  public function store(AdminFormRequest $request)
  {
    $this->adminRepository->createAdmin($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.admins.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($admin)
  {

    $admin = $this->adminRepository->getAdminById($admin);

    $roles = $this->roleRepository->getAllRoles();

    return view($this->mainViewPrefix.'.admins.edit', compact('admin', 'roles'));
  } //end of edit

  public function update(AdminFormRequest $request, Admin $admin)
  {
    $this->adminRepository->updateAdmin($request, $admin);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.admins.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Admin $admin)
  {
    if (!$admin) {
      return redirect()->back();
    }
    $this->adminRepository->deleteAdmin($admin);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.admins.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
