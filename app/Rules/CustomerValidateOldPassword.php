<?php

namespace App\Rules;

use App\Traits\AuthenticateCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class CustomerValidateOldPassword implements Rule
{

  use AuthenticateCustomer;
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
    //  try login
    if (!Auth::guard('customer')->attempt([
      'email' => getCustomer()->email,
      'password' => request()->old_password
    ])) {
      return false;
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
    return __('site.Old password not correct');
  }
}
