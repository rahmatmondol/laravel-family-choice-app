<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;
use App\Rules\ValidateSaudiPhoneNumber;

class AdminFormRequest extends BaseRequest
{

  public $rules = [
    'first_name' => 'required',
    'roels' => 'array|min:1',
    'roles.*' => 'required|exists:roles,id',
  ];

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    if ($this->isMethod('post')) {
      return $this->createRules();
    } elseif ($this->isMethod('put')) {
      return $this->updateRules();
    }
  }
  public function createRules()
  {
    $this->rules += [
      'email' => ['nullable', 'email', 'unique:admins', new CheckEmailExist('admins')],
      'password' => ['required', 'string', 'min:6'],
      'password_confirmation' => ['required', 'same:password', 'min:6'],
      'image' => validateImage(),
    ];
    return $this->rules;
  }

  public function updateRules()
  {
    $admin = $this->route('admin');
    $this->rules += [
      'email' => ['nullable', 'email', 'unique:admins,email,' . $admin->id, new CheckEmailExist('admins')],
      'image' => validateImage(),
      'password' => 'nullable|confirmed',
    ];
    return $this->rules;
  }
}
