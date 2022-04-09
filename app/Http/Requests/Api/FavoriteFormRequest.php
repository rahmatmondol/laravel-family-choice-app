<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class FavoriteFormRequest extends BaseRequest
{

  public $rules = []; // end rules

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'school_id' => ['bail', 'required', 'exists:schools,id'],
    ];
    return $this->rules;
  }
}
