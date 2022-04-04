<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolGrade extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $table = 'school_grade';

  public function school()
  {
    return $this->belongsTo(School::class);
  } // end of user

  public function grade()
  {
    return $this->belongsTo(Grade::class);
  } // end of user
}
