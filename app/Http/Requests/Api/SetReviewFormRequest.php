<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class SetReviewFormRequest extends BaseRequest
{

  public $rules = []; // end rules

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $this->rules += [
      'comment' => 'required',
      'school_id' => 'required|exists:schools,id',
      'follow_up' => 'required|integer|min:1|max:5',
      'quality_of_education' => 'required|integer|min:1|max:5',
      'cleanliness' => 'required|integer|min:1|max:5',
    ];
    return $this->rules;
  }
}
