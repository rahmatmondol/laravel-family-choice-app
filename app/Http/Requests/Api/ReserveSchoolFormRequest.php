<?php

namespace App\Http\Requests\Api;

use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;
use App\Models\School;

class ReserveSchoolFormRequest extends BaseRequest
{
  public $rules = [];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'parent_name' => 'required|string|max:255',
      'address' => 'required|string|max:255',
      'identification_number' => 'required|string|max:255',
      'school_id' => ['required', 'bail', 'exists:schools,id'],
    ];

    if ($this->isMethod('post')) {
      return $this->createRules();
    } elseif ($this->isMethod('put')) {
      return $this->updateRules();
    }
  }

  public function createRules()
  {
    $this->rules += [
      'children' => ['required', 'array'],
      'children.*.child_name' => ['required', 'string', 'max:255'],
      'children.*.date_of_birth' => ['required', 'date', 'before:yesterday', 'date_format:Y-m-d'],
      'children.*.gender' => ['required', 'in:male,female'],
      'children.*.grade_id' => ['required', 'exists:grades,id'],
      'children.*.attachments' => ['required', 'array'],
      // 'children.*.attachments.attachment_id' => ['required', 'exists:attachments,id'],
      // 'children.*.attachments.attachment' => ['required'],
    ];

    $school = School::findOrFail(request()->school_id);

    // dd($school->attachments->pluck('id')->toArray());
    foreach ($school->attachments->pluck('id')->toArray() as $attachment_id) {
      $this->rules += ['children.*.attachments.*.' . $attachment_id => ['required']];
    } // end of  for each

    // dd($this->rules);
    return $this->rules;
  }

  public function updateRules()
  {
    $customer = $this->getCustomer();
    $this->rules += [
      'email' => ['required', 'email', 'unique:customers,email,' . $customer->id, new CheckEmailExist("customers")],
      'phone' => ['bail', 'required', 'unique:customers,phone,' . $customer->id],
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
