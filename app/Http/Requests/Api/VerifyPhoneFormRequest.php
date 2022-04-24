<?php

namespace App\Http\Requests\Api;

use App\Models\Customer;
use App\Http\Requests\BaseRequest;

class VerifyPhoneFormRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'phone' => 'required|string|exists:customers,phone',
      'verification_code' => ['bail', 'required', 'string', 'exists:customers,verification_code', function ($attribute, $value, $fail) {
        $customer = Customer::where('phone', request('phone'))->where('verification_code', request('verification_code'))->first();
        if (!$customer) {
          $fail(__('site.User not found'));
        }
        // if ($customer->verified == 1) {
        //   $fail(__('site.User already verified'));
        // }
      }],
    ];
  }
}
