<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TypeFormRequest extends FormRequest
{
  public $rules = [];

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

    $this->rules += [];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('type_translations', 'title')]];
    } // end of  for each

    return $this->rules;
  }

  public function updateRules()
  {

    $type = $this->route('type');

    $this->rules += [];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('type_translations', 'title')->ignore($type->id, 'type_id')]];
    } // end of  for each

    $this->rules += [];
    return $this->rules;
  }
}
