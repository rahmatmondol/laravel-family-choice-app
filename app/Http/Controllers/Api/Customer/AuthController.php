<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Customer;

use Illuminate\Http\Request;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCustomerFormRequest;
use App\Traits\AuthenticateCustomer;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\LoginFormRequest;
use App\Http\Requests\Api\SendCodeFormRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Http\Requests\Api\VerifyPhoneFormRequest;
use App\Http\Requests\Api\ForgetPasswordFormRequest;
use App\Http\Requests\Api\UpdateFirebaseTokenFormRequest;
use App\Http\Requests\Api\CustomerChangePasswordFormRequest;
use App\Http\Requests\UpdateCustomerFormRequest;

class AuthController extends Controller
{
  use ResponseTrait, AuthenticateCustomer;

  public function __construct(
    private CustomerRepositoryInterface $customerRepository
  ) {
  } //end of constructor

  public function signupCustomer(AddCustomerFormRequest $request)
  {
    $customer = $this->customerRepository->createCustomer($request);

    $customer = new CustomerResource($customer);
    return $this->sendResponse($customer, "");
  }

  public function editCustomerProfile(UpdateCustomerFormRequest $request)
  {
    $this->customerRepository->updateCustomer($request, getCustomer());

    return $this->sendResponse("", "Success update");
  }

  public function login(LoginFormRequest $request)
  {
    if (!$this->customerRepository->loginCustomer($request)) {
      return $this->sendError(__('site.Password not correct'), '');
    }
    $customer = getCustomer();
    if ($customer->status == 0) {
      return $this->sendError(__('site.User blocked from admin'), '');
    }

    return $this->sendResponse(new CustomerResource($customer), '');
  }

  // // send or resend code
  public function sendCode(SendCodeFormRequest $request)
  {
    $this->customerRepository->sendCodeToCustomer($request);
    return $this->sendResponse("", "");
  }

  // used only for developers to get the code sent throught sms
  public function getVerificationCode(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'phone' => ['required', 'exists:customers,phone'],
    ]);

    if ($validator->fails()) {
      return $this->sendError(' ', $validator->errors());
    }

    $customer = Customer::where('phone', request('phone'))->first();

    return $this->sendResponse($customer->verification_code ?? "", "");
  }

  #used for verify phone and forget password
  public function verifyPhone(VerifyPhoneFormRequest $request)
  {
    $customer = Customer::where('phone', $request->phone)->firstOrFail();
    $customer->update(['verified' => 1]);
    // $this->resetVerificationCode($customer);

    return $this->sendResponse("", "");
  }

  public function updateFirebaseToken(UpdateFirebaseTokenFormRequest $request)
  {
    getCustomer()->update(['firebaseToken' => $request->firebaseToken]);
    return $this->sendResponse("", "");
  }

  public function logout(Request $request)
  {
    getCustomer()->token()->revoke();
    return $this->sendResponse("", __('site.Successfully logged out'));
  }

  public function profile(Request $request)
  {
    return $this->sendResponse(new CustomerResource(getCustomer()), "");
  }

  public function foregetPassword(ForgetPasswordFormRequest $request)
  {
    $customer = $this->customerRepository->forgetCustomerPassword($request);
    $this->resetVerificationCode($customer);
    return $this->sendResponse("", "");
  }

  public function changePassword(CustomerChangePasswordFormRequest $request)
  {

    $this->customerRepository->changePasswordCustomer($request);

    return $this->sendResponse("", "");
  }

  public function resetVerificationCode($customer)
  {
    $customer->update(['verification_code' => null]);
  }
}
