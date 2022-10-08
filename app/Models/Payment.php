<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  use HasFactory;
  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  public function scopeWhenSearch($query)
  {
    $search = request()->search;
    return $query->when($search, function ($q) use ($search) {
      if($school = getAuthSchool()){
        return $q->where('reservation_id', $search )->where('school_id',$school->id);
      }else{
        return $q->where('reservation_id', $search );
      }
    });
  } // end of scopeWhenSearch

  public function scopeWhenStatus($query, $status = null)
  {
    if ($status != null)
      return $query->where('payment_status', $status);
  }

  public function scopeWhenSchool($query, $school_id)
  {
    $school_id = getAuthSchool() ? getAuthSchool()->id : $school_id;
    return $query->when($school_id, function ($q) use ($school_id) {

      return $q->whereHas('school', function ($qu) use ($school_id) {

        return $qu->where('school_id', $school_id);
      });
    });
  } // end of

  /////////////////// start relationships ///////////////////////////////
  public function school()
  {
    return $this->belongsTo(School::class);
  }

  public function reservation()
  {
    return $this->belongsTo(Reservation::class);
  }
  ////////////////// end relationships /////////////////////////////////
}
