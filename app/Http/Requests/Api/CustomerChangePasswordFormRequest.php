<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Rules\CustomerValidateOldPassword;

class CustomerChangePasswordFormRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return $this->createRules();
  }
  public function createRules()
  {
    return  [
      'password' => 'required|string|min:6',
      'password_confirmation' => 'required|same:password|min:6',
      'old_password' => ['required', new CustomerValidateOldPassword()],
    ];
  }
}
