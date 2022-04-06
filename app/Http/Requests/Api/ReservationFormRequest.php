<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class ReservationFormRequest extends BaseRequest
{

  public $rules = [
    'number_of_students' => 'required|integer',
    'number_of_students' => 'required|integer',
    'place' => 'required|string|in:home,center',
    'order_type' => 'required|string|in:hours,week,month',
    'number_of_hours' => 'required|integer',
    'teacher_id' => 'required|exists:teachers,id',
    // 'category_id'=>'required_if:subject_id,==,null|exists:categories,id',
    // 'subject_id'=>'required_if:category_id,==,null|exists:subjects,id',
    'requestType' => "required|in:create,edit",

  ];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    if ($this->requestType == 'create') {
      return $this->createRules();
    } elseif ($this->requestType == 'edit') {
      return $this->updateRules();
    } else {
      return $this->rules;
    }
  }
  public function createRules()
  {
    return $this->rules;
  }
  public function updateRules()
  {
    return $this->rules;
  }
}
