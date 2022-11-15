<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class ReservationDetailsFormRequest extends BaseRequest
{
  public $rules = [];

  protected $stopOnFirstFailure = true;

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'reservation_id' => ['required', 'exists:reservations,id'],
    ];

    return $this->rules;
  }
}
