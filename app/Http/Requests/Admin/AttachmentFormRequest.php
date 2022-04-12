<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AttachmentFormRequest extends FormRequest
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
      $this->rules += [$locale . '.title' => ['required', Rule::unique('attachment_translations', 'title')]];
    } // end of  for each

    return $this->rules;
  }


  public function updateRules()
  {

    $attachment = $this->route('attachment');

    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required', Rule::unique('attachment_translations', 'title')->ignore($attachment->id, 'attachment_id')]];
    } // end of  for each

    $this->rules += [];

    return $this->rules;
  }
}
