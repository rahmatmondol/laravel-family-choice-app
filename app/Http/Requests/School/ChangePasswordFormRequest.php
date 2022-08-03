<?php

namespace App\Http\Requests\School;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordFormRequest extends BaseRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return $this->createRules();
  }

  public function createRules()
  {
    return  [
      'password' => 'required|string|min:6',
      'password_confirmation' => 'required|same:password|min:6',
      'current_password' => ['required', function ($attribute, $value, $fail) {
        if (!(Hash::check($value, getAuthSchool()->password))) {
          $fail(__('site.Your current password does not matches with the password.'));
        }
      }]
    ];
  }
}
