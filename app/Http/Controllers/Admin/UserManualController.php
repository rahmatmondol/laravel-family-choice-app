<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserManual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\UserManualRepositoryInterface;
use App\Http\Requests\Admin\UserManualFormRequest;

class UserManualController extends BaseController
{

  public function __construct(
    private UserManualRepositoryInterface $userManualRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_user_manuals'])->only('index');
    $this->middleware(['permission:create_user_manuals'])->only('create');
    $this->middleware(['permission:update_user_manuals'])->only('edit');
    $this->middleware(['permission:delete_user_manuals'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $user_manuals = $this->userManualRepository->getFilteredUserManuals($request);

    return view($this->mainViewPrefix.'.user_manuals.index', compact('user_manuals'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view($this->mainViewPrefix.'.user_manuals.create', compact('roles'));
  } //end of create

  public function show($user_manual)
  {
    $user_manual = $this->userManualRepository->getUserManualById($user_manual);

    return view($this->mainViewPrefix.'.user_manuals.show', compact('user_manual'));
  } //end of create

  public function store(UserManualFormRequest $request)
  {
    $this->userManualRepository->createUserManual($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.user_manuals.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($user_manual)
  {

    $user_manual = $this->userManualRepository->getUserManualById($user_manual);

    return view($this->mainViewPrefix.'.user_manuals.edit', compact('user_manual',));
  } //end of edit

  public function update(UserManualFormRequest $request, UserManual $user_manual)
  {
    $this->userManualRepository->updateUserManual($request, $user_manual);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.user_manuals.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(UserManual $user_manual)
  {
    if (!$user_manual) {
      return redirect()->back();
    }
    $this->userManualRepository->deleteUserManual($user_manual);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.user_manuals.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
