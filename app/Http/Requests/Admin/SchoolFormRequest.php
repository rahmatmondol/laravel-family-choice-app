<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckEmailExist;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolFormRequest extends FormRequest
{
  public $rules = [
    'type' => ['required', 'in:school,nursery'],
    'available_seats' => ['nullable', 'integer'],
    'fees' => ['required', 'integer'],
  ];

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
      'email' => ['required', 'email', 'unique:schools', new CheckEmailExist("schools")],
      'phone' => [
        'bail', 'required', 'unique:schools,phone'
        // , new ValidatePhoneNumber()
      ],
      'password' => ['required', 'string', 'min:6'],
      'password_confirmation' => ['required', 'same:password', 'min:6'],
      'image' => validateImage(),
      'attachments' => ['nullable'],
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
    $school = $this->route('school');

    $this->rules += [
      'email' => ['required', 'email', 'unique:schools,email,' . $school->id, new CheckEmailExist("schools")],
      'phone' => ['bail', 'required', 'unique:schools,phone,' . $school->id],
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
