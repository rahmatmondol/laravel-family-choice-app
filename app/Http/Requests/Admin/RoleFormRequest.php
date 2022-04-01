<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RoleFormRequest extends BaseRequest
{
  public $rules = [
    'permissions' => 'required|array|min:1',
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
      'name' => 'required|unique:roles,name',
    ];
    return $this->rules;
  }

  public function updateRules()
  {

    $role = $this->route('role');

    $this->rules += [
      'name' => 'required|unique:roles,name,' . $role->id,
    ];

    return $this->rules;
  }
}
