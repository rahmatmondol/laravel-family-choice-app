<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaidService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\PaidServiceRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\PaidServiceFormRequest;
use App\Interfaces\SubscriptionRepositoryInterface;

class PaidServiceController extends BaseController
{
  public function __construct(
    private PaidServiceRepositoryInterface $paidServiceRepository,
    private SchoolRepositoryInterface $schoolRepository,
    private SubscriptionRepositoryInterface $subscriptionRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_paidServices'])->only('index');
    $this->middleware(['permission:create_paidServices'])->only('create');
    $this->middleware(['permission:update_paidServices'])->only('edit');
    $this->middleware(['permission:delete_paidServices'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $paidServices = $this->paidServiceRepository->getFilteredPaidServices($request);
    $schools = $this->schoolRepository->getAllSchools();

    return view($this->mainViewPrefix.'.paidServices.index', compact('paidServices','schools'));
  } // end of index

  public function create(Request $request)
  {
    $schools = $this->schoolRepository->getAllSchools();

    return view($this->mainViewPrefix.'.paidServices.create', compact('schools'));
  } //end of create

  public function show($paidService)
  {
    $paidService = $this->paidServiceRepository->getPaidServiceById($paidService);

    return view($this->mainViewPrefix.'.paidServices.show', compact('paidService'));
  } //end of create

  public function store(PaidServiceFormRequest $request)
  {
    $this->paidServiceRepository->createPaidService($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.paidServices.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(Request $request,$paidService)
  {
    $paidService = $this->paidServiceRepository->getPaidServiceById($paidService);
    $schools = $this->schoolRepository->getAllSchools();

    return view($this->mainViewPrefix.'.paidServices.edit', compact('paidService','schools'));
  } //end of edit

  public function update(PaidServiceFormRequest $request, PaidService $paidService)
  {
    $this->paidServiceRepository->updatePaidService($request, $paidService);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.paidServices.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(PaidService $paidService)
  {
    if (!$paidService) {
      return redirect()->back();
    }
    $this->paidServiceRepository->deletePaidService($paidService);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.paidServices.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
