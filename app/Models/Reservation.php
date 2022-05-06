<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function scopeWhenSearch($query, $search)
  {
    return $query->when($search, function ($q) use ($search) {
      return $q->where('parent_name', 'like', "%$search%")
        ->orWhere('id', $search);
    });
  } // end of scopeWhenSearch

  public function scopeWhenStatus($query, $status)
  {
    return $query->when($status, function ($q) use ($status) {
      return $q->where('status', $status);
    });
  } // end of scopeWhenStatus

  public function scopeWhenPaymentStatus($query, $status)
  {
    return $query->when($status, function ($q) use ($status) {
      return $q->where('payment_status', $status);
    });
  } // end of scopeWhenPaymentStatus

  public function scopeWhenSchool($query)
  {
    $school_id = request()->school_id;

    return $query->when($school_id, function ($q) use ($school_id) {

      return $q->whereHas('school', function ($qu) use ($school_id) {

        return $qu->where('school_id', $school_id);
      });
    });
  } // end of

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
