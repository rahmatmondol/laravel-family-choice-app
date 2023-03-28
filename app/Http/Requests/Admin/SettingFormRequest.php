<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;

class SettingFormRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'email' => ['required', 'email'],
      'phone' => ['required'],
      'partial_payment_percent' => ['required','numeric','min:1','max:90'],
    ];
  }
}
