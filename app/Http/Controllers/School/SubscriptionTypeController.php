<?php

namespace App\Http\Controllers\School;

use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\SubscriptionTypeRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\School\BaseController;
use App\Http\Requests\Admin\SubscriptionTypeFormRequest;
use App\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionTypeController extends BaseController
{
  public function __construct(
    private SubscriptionTypeRepositoryInterface $subscriptionTypeRepository,
    private SchoolRepositoryInterface $schoolRepository,
    private SubscriptionRepositoryInterface $subscriptionRepository
  ) {
    parent::__construct();
    //create read update delete
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $subscriptionTypes = $this->subscriptionTypeRepository->getFilteredSubscriptionTypes($request);
    $subscriptions = $this->subscriptionRepository->getAllSubscriptions();
    return view($this->mainViewPrefix.'.subscriptionTypes.index', compact('subscriptionTypes','subscriptions'));
  } // end of index

  public function create(Request $request)
  {
    $subscriptions = $this->subscriptionRepository->getAllSubscriptions();
    return view($this->mainViewPrefix.'.subscriptionTypes.create', compact('subscriptions'));
  } //end of create

  public function show($subscriptionType)
  {
    $subscriptionType = $this->subscriptionTypeRepository->getSubscriptionTypeById($subscriptionType);

    return view($this->mainViewPrefix.'.subscriptionTypes.show', compact('subscriptionType'));
  } //end of create

  public function store(SubscriptionTypeFormRequest $request)
  {
    $this->subscriptionTypeRepository->createSubscriptionType($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.subscriptionTypes.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(Request $request,$subscriptionType)
  {

    $subscriptionType = $this->subscriptionTypeRepository->getSubscriptionTypeById($subscriptionType);
    $subscriptions = $this->subscriptionRepository->getAllSubscriptions();
    return view($this->mainViewPrefix.'.subscriptionTypes.edit', compact('subscriptionType','subscriptions'));
  } //end of edit

  public function update(SubscriptionTypeFormRequest $request, SubscriptionType $subscriptionType)
  {
    $this->subscriptionTypeRepository->updateSubscriptionType($request, $subscriptionType);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.subscriptionTypes.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(SubscriptionType $subscriptionType)
  {
    if (!$subscriptionType) {
      return redirect()->back();
    }
    $this->subscriptionTypeRepository->deleteSubscriptionType($subscriptionType);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.subscriptionTypes.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
