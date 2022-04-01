<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Traits\AuthenticateCustomer;

class LoginFormRequest extends BaseRequest
{

  use AuthenticateCustomer;
  public $rules = [
    'password' => 'required|string',
    'remember_me' => 'boolean'
  ];

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    if ($this->isMethod('post')) {
      return $this->createRules();
    } elseif ($this->isMethod('put')) {
      return $this->updateRules();
    }
  }

  public function createRules()
  {
    $type  = $this->checkInputType(request('email'));

    if ($type == 'email') {
      $this->rules['email'] = 'required|string|email|exists:customers,email';
    } elseif ($type == 'phone') { // remove email validation
      $this->rules['email'] = 'required|string|exists:customers,phone';
    } else {
      $this->rules['email'] = ['required', function ($attribute, $value, $fail) {
        $fail(__('site.Please Enter Correct Phone Or E-mail'));
      }];
    }

    return $this->rules;
  }

  public function updateRules()
  {
    return $this->rules;
  }

  public function messages()
  {
    $messages = [];
    $type  = $this->checkInputType(request('email'));

    if ($type == 'phone') {
      $messages['email.exists'] = __('site.The selected phone is invalid.');
    }
    $messages['email.required'] = __('site.The email or phone field is required.');
    return $messages;
  }
}
