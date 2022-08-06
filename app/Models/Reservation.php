<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

  public function scopeWhenSchool($query, $school_id)
  {
    $school_id = getAuthSchool() ? getAuthSchool()->id : $school_id;
    return $query->when($school_id, function ($q) use ($school_id) {

      return $q->whereHas('school', function ($qu) use ($school_id) {

        return $qu->where('school_id', $school_id);
      });
    });
  } // end of

  public function scopeWhenCourse($query, $course_id)
  {
    return $query->when($course_id, function ($q) use ($course_id) {

      return $q->whereHas('course', function ($qu) use ($course_id) {

        return $qu->where('course_id', $course_id);
      });
    });
  } // end of

  public function scopeWhenCustomer($query, $customer_id)
  {
    return $query->when($customer_id, function ($q) use ($customer_id) {

      return $q->whereHas('customer', function ($qu) use ($customer_id) {

        return $qu->where('customer_id', $customer_id);
      });
    });
  } // end of

  public function scopeWhenDateRange($query, $date_range)
  {
    if ($date_range !== null && $date_range != (date('m/d/Y').' - '.date('m/d/Y'))) {
      $arr = explode('-', $date_range);
      $from_date = date('Y-m-d',strtotime(trim($arr[0])));
      $to_date = date('Y-m-d',strtotime(trim($arr[1])));
      return $query->whereDate('created_at', '>=',$from_date)->whereDate('created_at', '<=',$to_date);
    }
  } // end of

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function school()
  {
    return $this->belongsTo(School::class);
  }

  public function course()
  {
    return  $this->belongsTo(Course::class);
  }

  public function child()
  {
    return $this->hasOne(Child::class);
  }
}
