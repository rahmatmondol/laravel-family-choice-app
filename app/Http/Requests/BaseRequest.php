<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{
  /**
   * Determine if user authorized to make this request
   * @return bool
   */
  public function authorize()
  {
    return true;
  }
  /**
   * If validator fails return the exception in json form
   * @param Validator $validator
   * @return array
   */
  protected function failedValidation(Validator $validator)
  {
    // endpoints
    if (request()->is('api/*')) {
      throw new HttpResponseException(response()->json(['success' => false, 'data' => $validator->errors()], 422));
    }
    // web
    throw (new ValidationException($validator))
      ->errorBag($this->errorBag)
      ->redirectTo($this->getRedirectUrl());
  }
  abstract public function rules();
}
