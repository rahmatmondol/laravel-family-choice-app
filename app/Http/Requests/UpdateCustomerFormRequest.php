<?php

namespace App\Http\Requests;

use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;
use App\Rules\ValidatePhoneNumber;

class UpdateCustomerFormRequest extends BaseRequest
{

  public $rules = [];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $customer = $this->getCustomer();
    return  [
      'full_name' => 'required|string|max:255',
      'city_id' => 'nullable|exists:cities,id',
      'gender' => 'nullable|in:male,female',
      'date_of_birth' => ['nullable', 'date', 'before:yesterday', 'date_format:Y-m-d'],
      'email' => ['required', 'email', 'unique:customers,email,' . $customer->id, new CheckEmailExist("customers")],
      'phone' => ['bail', 'required', 'unique:customers,phone,' . $customer->id],
      'password' => 'nullable|confirmed',
      'image' => validateImage(),
    ];
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
