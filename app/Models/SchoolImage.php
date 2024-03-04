<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolImage extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function school()
  {
    return $this->belongsTo(Product::class);
  } //end of user

  public function getImagePathAttribute()
  {
    return asset('uploads/school_images/' . $this->image);
  } // end of get image path
}
