<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckEmailExist;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolFormRequest extends FormRequest
{
  public $rules = [];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'available_seats' => ['nullable', 'integer'],
      'fees' => ['required', 'integer'],
      'lat' => ['nullable'],
      'lng' => ['nullable'],

      'type_id' => 'required|exists:types,id',

      'educationalSubjects' => 'nullable|array',
      'educationalSubjects.*' => 'nullable|exists:educational_subjects,id',

      'educationTypes' => 'nullable|array',
      'educationTypes.*' => 'nullable|exists:education_types,id',

      'schoolTypes' => 'nullable|array',
      'schoolTypes.*' => 'nullable|exists:school_types,id',
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
      'email' => ['required', 'email', 'unique:schools', new CheckEmailExist("schools")],
      'phone' => [
        'bail', 'required', 'unique:schools,phone'
      ],
      'whatsapp' => [
        'nullable', 'unique:schools,whatsapp'
      ],
      'password' => ['required', 'string', 'min:6'],
      'password_confirmation' => ['required', 'same:password', 'min:6'],
      'image' => validateImage(),
      'attachments' => ['nullable'],+
      'attachments.*' => 'required|' . validateImage(),
    ];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('school_translations', 'title')]];
      $this->rules += [$locale . '.address' => ['required']];
      $this->rules += [$locale . '.description' => ['required']];
    } // end of  for each

    return $this->rules;
  }

  public function updateRules()
  {
    $school = request()->is('school/*') ? getAuthSchool() : $this->route('school');

    $this->rules += [
      'email' => ['required', 'email', 'unique:schools,email,' . $school->id, new CheckEmailExist("schools")],
      'phone' => ['bail', 'required', 'unique:schools,phone,' . $school->id],
      'whatsapp' => ['nullable', 'unique:schools,whatsapp,' . $school->id],
      'image' => validateImage(),
      'password' => 'nullable|confirmed',
      'attachments' => 'nullable',
      'attachments.*' => 'nullable|' . validateImage(),
    ];

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('school_translations', 'title')->ignore($school->id, 'school_id')]];
      $this->rules += [$locale . '.address' => ['required']];
      $this->rules += [$locale . '.description' => ['required']];
    } // end of  for each

    return $this->rules;
  }
}
