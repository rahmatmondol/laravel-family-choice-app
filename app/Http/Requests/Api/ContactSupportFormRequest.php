<?php

namespace App\Http\Requests\Api;

use App\Models\Customer;
use App\Http\Requests\BaseRequest;

class ContactSupportFormRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'full_name' => 'required|string',
      'problem_title' => 'required|string',
      'message' => 'required|string',
    ];
  }
}
