<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  use HasFactory;
  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];


  public function customer()
  {
    return $this->belongsTo(Customer::class);
  } //end fo category

}
