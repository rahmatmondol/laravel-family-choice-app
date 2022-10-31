<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurserySubscription extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $table = 'nursery_subscription';

  public function school()
  {
    return $this->belongsTo(School::class);
  } // end of user

  public function subscription()
  {
    return $this->belongsTo(Subscription::class);
  } // end of user
}
