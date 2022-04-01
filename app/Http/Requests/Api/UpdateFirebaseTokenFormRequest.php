<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class UpdateFirebaseTokenFormRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return  [
      'firebaseToken' => 'required|string',
    ];
  }
}
