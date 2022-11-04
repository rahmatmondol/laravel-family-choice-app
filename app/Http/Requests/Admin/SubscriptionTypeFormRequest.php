<?php

namespace App\Http\Requests\Admin;

use App\Enums\SubscriptionTypes;
use App\Rules\ValidateCurrentSchool;
use Illuminate\Foundation\Http\FormRequest;

class SubscriptionTypeFormRequest extends FormRequest
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
      'subscription_id' => ['required', 'exists:subscriptions,id'],
      'type' => ['required', 'in:'. implode(',',SubscriptionTypes::values()) ],
      'price' => ['required', 'numeric',],
      'number_of_days' => ['required', 'integer',],
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
      $this->rules += [$locale . '.appointment' => ['required']];
    } // end of  for each

    return $this->rules;
  }

  public function updateRules()
  {
    foreach (config('translatable.locales') as $locale) {
      $this->rules += [$locale . '.title' => ['required']];
      $this->rules += [$locale . '.appointment' => ['required']];
    } // end of  for each

    $this->rules += [];
    return $this->rules;
  }
}
