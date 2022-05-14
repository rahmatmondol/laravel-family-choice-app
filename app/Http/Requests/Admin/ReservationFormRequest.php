<?php

namespace App\Http\Requests\Admin;

use App\Enums\ReservationStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class ReservationFormRequest extends FormRequest
{
  public $rules = [];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'reason_of_refuse' => ['nullable', 'required_if:status,' . ReservationStatus::Rejected->value],
    ];

    if ($this->isMethod('post')) {
      return $this->createRules();
    } elseif ($this->isMethod('put')) {
      return $this->updateRules();
    }
  }

  public function createRules()
  {
  }

  public function updateRules()
  {
    $this->rules += [
      'status'      => ['required', new Enum(ReservationStatus::class)],
    ];
    return $this->rules;
  }
}
