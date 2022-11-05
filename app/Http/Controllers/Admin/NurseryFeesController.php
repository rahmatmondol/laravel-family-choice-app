<?php

namespace App\Http\Controllers\Admin;

use App\Models\NurseryFees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\NurseryFeesRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\NurseryFeesFormRequest;
use App\Interfaces\SubscriptionRepositoryInterface;

class NurseryFeesController extends BaseController
{
  public function __construct(
    private NurseryFeesRepositoryInterface $nurseryFeesRepository,
    private SchoolRepositoryInterface $schoolRepository,
    private SubscriptionRepositoryInterface $subscriptionRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_nurseryFees'])->only('index');
    $this->middleware(['permission:create_nurseryFees'])->only('create');
    $this->middleware(['permission:update_nurseryFees'])->only('edit');
    $this->middleware(['permission:delete_nurseryFees'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $nurseryFees = $this->nurseryFeesRepository->getFilteredNurseryFees($request);
    $schools = $this->schoolRepository->getAllSchools(true);

    return view($this->mainViewPrefix.'.nurseryFees.index', compact('nurseryFees','schools'));
  } // end of index

  public function create(Request $request)
  {
    $schools = $this->schoolRepository->getSchools($request,true);
    return view($this->mainViewPrefix.'.nurseryFees.create', compact('schools'));
  } //end of create

  public function show($nurseryFees)
  {
    $nurseryFees = $this->nurseryFeesRepository->getNurseryFeesById($nurseryFees);

    return view($this->mainViewPrefix.'.nurseryFees.show', compact('nurseryFees'));
  } //end of create

  public function store(NurseryFeesFormRequest $request)
  {
    $this->nurseryFeesRepository->createNurseryFees($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.nurseryFees.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(Request $request,$nurseryFees)
  {
    $nurseryFees = $this->nurseryFeesRepository->getNurseryFeesById($nurseryFees);
    $schools = $this->schoolRepository->getSchools($request,true);
    return view($this->mainViewPrefix.'.nurseryFees.edit', compact('nurseryFees','schools'));
  } //end of edit

  public function update(NurseryFeesFormRequest $request, NurseryFees $nurseryFee)
  {
    $this->nurseryFeesRepository->updateNurseryFees($request, $nurseryFee);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.nurseryFees.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(NurseryFees $nurseryFee)
  {
    if (!$nurseryFee) {
      return redirect()->back();
    }
    $this->nurseryFeesRepository->deleteNurseryFees($nurseryFee);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.nurseryFees.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
