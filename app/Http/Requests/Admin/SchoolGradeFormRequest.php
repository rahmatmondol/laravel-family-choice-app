<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolGradeFormRequest extends FormRequest
{
  public $rules = [];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'fees' => ['required', 'integer'],
      'administrative_expenses' => ['required', 'integer'],
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
      'grade_id' => 'required|exists:grades,id',
    ];
    return $this->rules;
  }

  public function updateRules()
  {
    return $this->rules;
  }
}
