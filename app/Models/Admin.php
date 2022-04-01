<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{

  protected $guarded = [];

  use LaratrustUserTrait, HasApiTokens, Notifiable, HasFactory;

  public function getFullNameAttribute($value)
  {
    return $this->first_name . " " . $this->last_name;
  } //end of get first name

  public function getImagePathAttribute()
  {
    return asset('uploads/admins/' . $this->image);
  } //end of get image path
  ##################### start scopes #############################

  public function scopeWhenSearch($query, $search)
  {
    return $query->when($search, function ($q) use ($search) {
      return $q->where('first_name', 'like', "%$search%")
        ->orWhere('last_name', 'like', "%$search%")
        ->orWhere('email', 'like', "%$search%");
    });
  } // end of scopeWhenSearch

  public function scopeIsActive($query, $status = null)
  {
    if ($status != null)
      return $query->where('status', (bool)$status);
  }
  ##################### end scopes #############################

  ##################### start relationships #############################
  ##################### end relationships #############################

}
