<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidateCurrentSchool;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GradeFeesFormRequest extends FormRequest
{
  public $rules = [];

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $this->rules += [
      'school_id' => ['required', 'exists:schools,id', new ValidateCurrentSchool()],
      'grade_id' => ['required', 'exists:grades,id'],
      'price' => ['required', 'numeric',],
    ];

    if ($this->isMethod('post')) {
      return $this->createRules();
    } elseif ($this->isMethod('put')) {
      return $this->updateRules();
    }
  }

  public function createRules()
  {
    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required']];
    } // end of  for each

    return $this->rules;
  }

  public function updateRules()
  {
    $nurseryFees = $this->route('nurseryFees');

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required']];
    } // end of  for each

    $this->rules += [];

    return $this->rules;
  }
}
