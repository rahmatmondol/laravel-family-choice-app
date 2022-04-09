<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserManualFormRequest extends FormRequest
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
    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required']];
      $this->rules += [$locale . '.description' => ['required']];
    } // end of  for each

    return $this->rules;
  }

  public function updateRules()
  {
    $user_manual = $this->route('user_manual');

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required']];
      $this->rules += [$locale . '.description' => ['required']];
    } // end of  for each
    return $this->rules;
  }
}
