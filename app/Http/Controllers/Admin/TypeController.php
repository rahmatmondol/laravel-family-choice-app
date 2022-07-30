<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\TypeRepositoryInterface;
use App\Http\Requests\Admin\TypeFormRequest;

class TypeController extends BaseController
{

  // use TypeTrait, PermissionTrait;

  public function __construct(
    private TypeRepositoryInterface $typeRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_types'])->only('index');
    $this->middleware(['permission:create_types'])->only('create');
    $this->middleware(['permission:update_types'])->only('edit');
    $this->middleware(['permission:delete_types'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $types = $this->typeRepository->getFilteredTypes($request);

    return view($this->mainViewPrefix.'.types.index', compact('types'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view($this->mainViewPrefix.'.types.create', compact('roles'));
  } //end of create

  public function show($type)
  {
    $type = $this->typeRepository->getTypeById($type);

    return view($this->mainViewPrefix.'.types.show', compact('type'));
  } //end of create

  public function store(TypeFormRequest $request)
  {
    $this->typeRepository->createType($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.types.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($type)
  {

    $type = $this->typeRepository->getTypeById($type);

    // $roles = $this->roleRepository->getAllRoles();

    return view($this->mainViewPrefix.'.types.edit', compact('type',));
  } //end of edit

  public function update(TypeFormRequest $request, Type $type)
  {
    $this->typeRepository->updateType($request, $type);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.types.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Type $type)
  {
    if (!$type) {
      return redirect()->back();
    }
    $this->typeRepository->deleteType($type);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.types.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
