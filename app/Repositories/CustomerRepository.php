<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Scopes\OrderScope;
use App\Models\Verification;
use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\CustomerRepositoryInterface;
use App\Traits\AuthenticateCustomer;

class CustomerRepository implements CustomerRepositoryInterface
{
  use UploadFileTrait, AuthenticateCustomer;

  public function getFilteredCustomers($request)
  {
    return  Customer::withoutGlobalScope(new OrderScope)
      ->with(['roles'])
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getCustomerById($customerId)
  {
    $customer = Customer::findOrFail($customerId);
    return $customer;
  }

  public function getCustomerRequestData($request)
  {
    $request_data = $request->only(['full_name', 'phone', 'email', 'verified', 'status', 'date_of_birth', 'gender', 'city_id']);
    return $request_data;
  }

  public function createCustomer($request)
  {
    $request_data = $this->getCustomerRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'customers/', '', '');
    } //end of if
    $request_data['password'] = bcrypt($request->password);

    $customer = Customer::create($request_data);

    if (request()->is('api/*')) {
      $this->sendVerificationCode($customer);
    }
    return   $customer;
  }

  public function updateCustomer($request, $customer)
  {
    $request_data = $this->getCustomerRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'customers/', $customer->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }

    if (request()->is('api/*')) {
      $request_data['phone'] = $customer->phone;
    }

    $customer->update($request_data);

    return true;
  }

  public function deleteCustomer($customer)
  {
    $this->removeImage($customer->image, 'customers');
    $customer->delete();
    return true;
  }

  #authentication
  public function loginCustomer($request)
  {
    $credentials  = [
      'password' => $request->password,
      // 'status' => 1,
      // 'verified' => 1
    ];

    $credentials = $this->credentials($credentials);

    if (Auth::guard('customer')->attempt($credentials)) {
      return true;
    }
    return false;
  }


  public function sendCodeToCustomer($request)
  {
    $customer = Customer::where('phone', $request->phone)->first();
    $this->sendVerificationCode($customer);
  }

  public function sendVerificationCode($customer)
  {
    $code = rand(1000, 9000);
    $customer->update([
      'verification_code' => $code,
    ]);

    // $this->sendSms($phone, $code);
  }

  // used only for developers to get the code sent throught sms
  public function getCustomerVerificationCode($request)
  {
    return Verification::where('phone', request('phone'))->first() ?? null;
  }

  public function verifyCustomerPhone($request)
  {
    Customer::where('phone', $request->phone)->update(['verified' => 1]);
  }

  public function forgetCustomerPassword($request)
  {
    $customer = Customer::where('phone', $request->phone)->firstOrFail();

    $customer->update(['password' => bcrypt($request->password)]);

    return $customer;
  }

  public function changeCustomerPassword($request)
  {
    $customer = Customer::where('phone', $request->phone)->firstOrFail();

    $customer->update(['password' => bcrypt($request->password)]);

    return $customer;
  }

  public function changePasswordCustomer($request)
  {
    getCustomer()->update(['password' => bcrypt($request->password)]);
  }

  public function logoutCustomer($request)
  {
    $request->user()->token()->revoke();
  }
}
