<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class GetSchoolAttachmentFormRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'school_id' => ['bail', 'required', 'exists:schools,id'],
    ];
  }
}
