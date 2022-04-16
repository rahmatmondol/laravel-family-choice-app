<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationAttachment extends Model
{
  use HasFactory;
  public function getImagePathAttribute()
  {
    return asset('uploads/reservation_attachments/' . $this->attachment);
  } //end of image path attribute
}
