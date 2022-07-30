<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerFormRequest;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\CustomerRepositoryInterface;

class CustomerController extends BaseController
{

  // use CustomerTrait, PermissionTrait;

  public function __construct(
    private CustomerRepositoryInterface $customerRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_customers'])->only('index');
    $this->middleware(['permission:create_customers'])->only('create');
    $this->middleware(['permission:update_customers'])->only('edit');
    $this->middleware(['permission:delete_customers'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $customers = $this->customerRepository->getFilteredCustomers($request);

    return view('admin.customers.index', compact('customers'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view('admin.customers.create', compact('roles'));
  } //end of create

  public function show($customer)
  {
    $customer = $this->customerRepository->getCustomerById($customer);

    return view('admin.customers.show', compact('customer'));
  } //end of create

  public function store(CustomerFormRequest $request)
  {
    $this->customerRepository->createCustomer($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.customers.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($customer)
  {

    $customer = $this->customerRepository->getCustomerById($customer);

    // $roles = $this->roleRepository->getAllRoles();

    return view('admin.customers.edit', compact('customer',));
  } //end of edit

  public function update(CustomerFormRequest $request, Customer $customer)
  {
    $this->customerRepository->updateCustomer($request, $customer);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.customers.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Customer $customer)
  {
    if (!$customer) {
      return redirect()->back();
    }
    $this->customerRepository->deleteCustomer($customer);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($mainRoutePrefix.'.customers.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
