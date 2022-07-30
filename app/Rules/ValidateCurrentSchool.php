<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateCurrentSchool implements Rule
{
  /**
   * Create a new rule instance.
   * $type :  check all tables except  type(table)
   * @return void
   */


  public function __construct()
  {
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value)
  {

    if (request()->is('school/*') && !empty(getAuthSchool()) && getAuthSchool()->id != $value) {
      return false ;
    }

    return true;
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */

  public function message()
  {
    return __('site.school id not valid');
  }
}
