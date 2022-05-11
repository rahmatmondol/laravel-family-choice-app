<?php

namespace App\Http\Requests;

use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;
use App\Rules\ValidatePhoneNumber;

class CustomerFormRequest extends BaseRequest
{

  public $rules = [
    'full_name' => 'required|string|max:255',
    'city_id' => 'nullable|exists:cities,id',
    'gender' => 'nullable|in:male,female',
    'date_of_birth' => ['nullable', 'date', 'before:yesterday', 'date_format:Y-m-d'],
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

    $this->rules += [
      'email' => ['required', 'email', 'unique:customers', new CheckEmailExist("customers")],
      'phone' => ['bail', 'required', 'unique:customers,phone', new ValidatePhoneNumber()],
      'password' => ['required', 'string', 'min:6'],
      'password_confirmation' => ['required', 'same:password', 'min:6'],
      'image' => validateImage(),
    ];

    return $this->rules;
  }

  public function updateRules()
  {
    $customer = $this->getCustomer();
    $this->rules += [
      'email' => ['required', 'email', 'unique:customers,email,' . $customer->id, new CheckEmailExist("customers")],
      'phone' => ['bail', 'required', 'unique:customers,phone,' . $customer->id],
      'password' => 'nullable|confirmed',
      'image' => validateImage(),
    ];
    return $this->rules;
  }

  public function getCustomer()
  {
    return   request()->is('api/*') ? getCustomer() : $this->route('customer');
  }

  public function messages()
  {
    return [
      'lat.required' => __('site.Please choose your location.'),
      'lng.required' => __('site.Please choose your location.'),
    ];
  }
}
