<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function school()
  {
    return $this->belongsTo(School::class);
  }

  public function children()
  {
    return $this->hasMany(Child::class);
  }
}
