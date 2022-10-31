<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Http\Requests\Admin\SubscriptionFormRequest;
use App\Http\Controllers\Admin\BaseController;

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

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $subscriptions = $this->subscriptionRepository->getFilteredSubscriptions($request);

    return view($this->mainViewPrefix.'.subscriptions.index', compact('subscriptions'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view($this->mainViewPrefix.'.subscriptions.create', compact('roles'));
  } //end of create

  public function show($subscription)
  {
    $subscription = $this->subscriptionRepository->getSubscriptionById($subscription);

    return view($this->mainViewPrefix.'.subscriptions.show', compact('subscription'));
  } //end of create

  public function store(SubscriptionFormRequest $request)
  {
    $this->subscriptionRepository->createSubscription($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.subscriptions.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($subscription)
  {
    $subscription = $this->subscriptionRepository->getSubscriptionById($subscription);

    return view($this->mainViewPrefix.'.subscriptions.edit', compact('subscription',));
  } //end of edit

  public function update(SubscriptionFormRequest $request, Subscription $subscription)
  {
    $this->subscriptionRepository->updateSubscription($request, $subscription);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.subscriptions.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Subscription $subscription)
  {
    if (!$subscription) {
      return redirect()->back();
    }
    $this->subscriptionRepository->deleteSubscription($subscription);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.subscriptions.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
