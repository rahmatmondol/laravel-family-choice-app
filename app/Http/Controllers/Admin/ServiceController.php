<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\ServiceRepositoryInterface;
use App\Http\Requests\Admin\ServiceFormRequest;

class ServiceController extends BaseController
{

  public function __construct(
    private ServiceRepositoryInterface $serviceRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_services'])->only('index');
    $this->middleware(['permission:create_services'])->only('create');
    $this->middleware(['permission:update_services'])->only('edit');
    $this->middleware(['permission:delete_services'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $services = $this->serviceRepository->getFilteredServices($request);

    return view($this->mainViewPrefix.'.services.index', compact('services'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view($this->mainViewPrefix.'.services.create', compact('roles'));
  } //end of create

  public function show($service)
  {
    $service = $this->serviceRepository->getServiceById($service);

    return view($this->mainViewPrefix.'.services.show', compact('service'));
  } //end of create

  public function store(ServiceFormRequest $request)
  {
    $this->serviceRepository->createService($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.services.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($service)
  {

    $service = $this->serviceRepository->getServiceById($service);

    // $roles = $this->roleRepository->getAllRoles();

    return view($this->mainViewPrefix.'.services.edit', compact('service',));
  } //end of edit

  public function update(ServiceFormRequest $request, Service $service)
  {
    $this->serviceRepository->updateService($request, $service);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.services.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Service $service)
  {
    if (!$service) {
      return redirect()->back();
    }
    $this->serviceRepository->deleteService($service);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.services.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
