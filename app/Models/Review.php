<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }

  public function school()
  {
    return $this->belongsTo(School::class, 'school_id', 'id');
  }

  public function getReviewAttribute()
  {
    return ($this->follow_up + $this->quality_of_education + $this->cleanliness) / 5;
  } //end of image path attribute
}
