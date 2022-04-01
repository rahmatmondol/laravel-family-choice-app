<?php

namespace App\Rules;

 
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class CheckPhoneExist implements Rule
{
  /**
   * Create a new rule instance.
   * $type :  check all tables except  type(table)
   * @return void
   */

  public $type = '';

  public function __construct($type)
  {
    $this->type = $type;

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

    #check all tables except  teachers table
    foreach( tables()  as $tbl ){
      if ($this->type == $tbl ) { // skip current table
        continue;
      }
      $count= DB::table($tbl)->where('phone', request('phone'))->count();
      if ($count > 0) {
        return false;
      }
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
    return __('site.Email Already EXists');
  }
}
