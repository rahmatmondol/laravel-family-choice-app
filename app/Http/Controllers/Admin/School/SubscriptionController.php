<?php

namespace App\Http\Controllers\Admin\School;

use App\Models\Subscription;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\SchoolSubscriptionFormRequest;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Services\School\SchoolSubscriptionService;

class SubscriptionController extends BaseController
{

  // use SubscriptionTrait, PermissionTrait;

  public function __construct(
    private SubscriptionRepositoryInterface $subscriptionRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_subscriptions'])->only('index');
    $this->middleware(['permission:create_subscriptions'])->only('create');
    $this->middleware(['permission:update_subscriptions'])->only('edit');
    $this->middleware(['permission:delete_subscriptions'])->only('destroy');
  } //end of constructor

  public function index(Request $request, School $school)
  {
    $subscriptions = SchoolSubscriptionService::getSchoolSubscriptions($school);
    return view($this->mainViewPrefix . '.schools.subscriptions.index', compact('school', 'subscriptions'));
  } // end of index

  public function create(Request $request, School $school)
  {
    $subscriptions = $this->subscriptionRepository->getAllSubscriptions();
    return view($this->mainViewPrefix . '.schools.subscriptions.create', compact('school', 'subscriptions'));
  } //end of create

  public function show(School $school, Subscription $subscription)
  {
    $schoolSubscription = SchoolSubscriptionService::getSchoolSubscription($school, $subscription);
    return view($this->mainViewPrefix . '.schools.subscriptions.show', compact('schoolSubscription'));
  } //end of create

  public function store(SchoolSubscriptionFormRequest $request, School $school)
  {
    SchoolSubscriptionService::storeSchoolSubscription($request,$request->school_id);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix . '.schools.subscriptions.index', ['school' => $school->id, 'page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(School $school, Subscription $subscription)
  {
    $subscriptions = $this->subscriptionRepository->getAllSubscriptions();

    $schoolSubscription = SchoolSubscriptionService::getSchoolSubscription($school, $subscription);

    return view($this->mainViewPrefix . '.schools.subscriptions.edit', compact('subscriptions', 'schoolSubscription', 'school'));
  } //end of edit

  public function update(SchoolSubscriptionFormRequest $request, School $school, Subscription $subscription)
  {
    SchoolSubscriptionService::updateSchoolSubscription($request,$school,$subscription);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix . '.schools.subscriptions.index', ['school' => $school->id, 'page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(School $school,Subscription $subscription)
  {
    if (!$subscription) {
      return redirect()->back();
    }
    SchoolSubscriptionService::deleteSchoolSubscription($school,$subscription);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix . '.schools.subscriptions.index', ['school' => $school->id, 'page' => session('currentPage')]);

  } //end of destroy

}//end of controller
