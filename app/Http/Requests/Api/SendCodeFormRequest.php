<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class SendCodeFormRequest extends BaseRequest
{

  public $rules = [
    'phone' => 'required|string|exists:customer,phone',
    'code' => 'required|string|exists:verifications,code',
  ];

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return  [
      'phone' => 'required|string|exists:customers,phone',
    ];
  }
}
