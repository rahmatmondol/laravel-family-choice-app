<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidatePhoneNumber implements Rule
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

    // if(substr($value,0,5) != '00971'){
    //   return false ;
    // }

    // if(strlen($value) != 14){
    //   return false ;
    // }
    return true;
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */

  public function message()
  {
    return __('site.format not correct');
  }
}
