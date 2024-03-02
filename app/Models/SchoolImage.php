<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
//
//      if (file_exists('uploads/school_images/'.$this->image)){
//          return asset('uploads/school_images/' . $this->image);
//      }
       return asset('uploads/school_images/default.png' );
  } // end of get image path
}
