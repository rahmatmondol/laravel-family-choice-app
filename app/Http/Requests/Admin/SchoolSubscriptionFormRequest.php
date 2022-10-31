<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolSubscriptionFormRequest extends FormRequest
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
      'subscription_id' => 'required|exists:subscriptions,id',
    ];
    return $this->rules;
  }

  public function updateRules()
  {
    return $this->rules;
  }
}
