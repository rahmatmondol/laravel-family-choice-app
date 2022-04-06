<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CourseFormRequest extends FormRequest
{
  public $rules = [];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'school_id' => ['required', 'exists:schools,id'],
      'type' => ['required', 'in:summery,wintry'],
      'from_date' => ['required', 'date', 'after:yesterday'],
      'to_date' => ['required', 'date', 'after:yesterday'],
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
      'image' => 'required|' . validateImage(),
    ];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('course_translations', 'title')]];
    } // end of  for each

    return $this->rules;
  }

  public function updateRules()
  {

    $course = $this->route('course');

    $this->rules += [
      'image' => validateImage(),
    ];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('course_translations', 'title')->ignore($course->id, 'course_id')]];
    } // end of  for each

    $this->rules += [];


    return $this->rules;
  }
}
