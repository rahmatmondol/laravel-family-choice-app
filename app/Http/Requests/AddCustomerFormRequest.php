<?php

namespace App\Http\Requests;

use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;
use App\Rules\ValidatePhoneNumber;

class AddCustomerFormRequest extends BaseRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return  [
      'full_name' => 'required|string|max:255',
      'city_id' => 'nullable|exists:cities,id',
      'gender' => 'nullable|in:male,female',
      'date_of_birth' => ['nullable', 'date', 'before:yesterday', 'date_format:Y-m-d'],
      'email' => ['required', 'email', 'unique:customers', new CheckEmailExist("customers")],
      'phone' => ['bail', 'required', 'unique:customers,phone', 'regex:/(971)[0-9]{9}/'],
      // 'phone' => ['bail', 'required', 'unique:customers,phone',new ValidatePhoneNumber()],
      'password' => ['required', 'string', 'min:6'],
      'password_confirmation' => ['required', 'same:password', 'min:6'],
      'image' => validateImage(),
    ];
  }

  public function messages()
  {
    return [
      'lat.required' => __('site.Please choose your location.'),
      'lng.required' => __('site.Please choose your location.'),
    ];
  }
}
