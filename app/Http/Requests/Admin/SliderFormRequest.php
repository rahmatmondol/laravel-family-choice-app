<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SliderFormRequest extends FormRequest
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

    $this->rules += [
      'image' => 'required|' . validateImage(),
    ];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('slider_translations', 'title')]];
    } // end of  for each

    return $this->rules;
  }

  public function updateRules()
  {

    $slider = $this->route('slider');

    $this->rules += [
      'image' => validateImage(),
    ];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('slider_translations', 'title')->ignore($slider->id, 'slider_id')]];
    } // end of  for each

    $this->rules += [];


    return $this->rules;
  }
}
