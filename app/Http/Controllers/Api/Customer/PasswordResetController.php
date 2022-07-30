<?php

namespace App\Http\Controllers\API\Customer;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Traits\Models\ResetPasswordTrait;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends BaseController
{

  use ResetPasswordTrait, ResponseTrait;

  public function create(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'email' => 'required|email|exists:customers',
    ]);

    if ($validator->fails()) {
      return $this->sendError(' ', $validator->errors());
    }


    $this->setToken($request->email, 'customers');

    return $this->sendResponse("", __('site.We have e-mailed your password reset link!') );
  }
}
