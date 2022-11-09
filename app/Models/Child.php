<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function reservation()
  {
    return $this->belongsTo(Reservation::class);
  }

  public function transportation()
  {
    return $this->belongsTo(Transportation::class);
  }

  public function grade()
  {
    return $this->belongsTo(Grade::class);
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function subscription_type()
  {
    return $this->belongsTo(SubscriptionType::class);
  }

  public function attachments()
  {
    return $this->hasMany(ChildAttachment::class, 'child_id', 'id');
  }
}
