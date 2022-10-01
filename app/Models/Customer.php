<?php

namespace App\Models;

use Illuminate\Contracts\Translation\HasLocalePreference;
use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends  Authenticatable implements HasLocalePreference
{
  use LaratrustUserTrait;
  use HasApiTokens, Notifiable;

  protected $guarded = [];

  public function getImagePathAttribute()
  {
    return asset('uploads/customers/' . $this->image);
  } //end of image path attribute

  //////////////////// start scopes /////////////////////////////////////
  public function scopeIsActive($query, $status = null)
  {
    if ($status != null)
      return $query->where('status', (bool)$status);
  }

  public function scopeWhenVerified($query, $verified)
  {
    if ($verified !== null) {
      return $query->where('verified', $verified);
    }
  }

  public function scopeWhenStatus($query, $status)
  {
    if ($status !== null) {
      return $query->where('status', $status);
    }
  }

  public function scopeWhenSearch($query, $search)
  {
    return $query->where('full_name', 'like', '%' . $search . '%')
      ->orwhere('phone', 'like', '%' . $search . '%')
      ->orwhere('email', 'like', '%' . $search . '%');
  } // end of scopeWhenSearch
  //////////////////// end scopes /////////////////////////////////////
  public function school_reservations()
  {
    return $this->hasMany(SchoolReservation::class);
  } //end fo category

  public function reviews()
  {
    return $this->hasMany(Review::class);
  } //end fo category

  public function city()
  {
    return $this->belongsTo(City::class);
  } //end fo category

  public function favorites()
  {
    return $this->belongsToMany(
      School::class,
      'favorites',
    );
  }

  public function reservations()
  {
    return $this->hasMany(Reservation::class);
  } //end fo category

  public function preferredLocale()
  {
      return 'ar';
  }

}
