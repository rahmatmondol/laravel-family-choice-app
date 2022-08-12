<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
  use HasFactory;


  public function getCauserFullNameAttribute()
  {
    $causer = $this->causer;
    if ($causer instanceof Admin || $causer instanceof Customer) {
      $causer_name = $causer?->full_name;
    } elseif ($causer instanceof School) {
      $causer_name = $causer?->title;
    }
    return $causer_name ?? $this->properties['causer_name'] ?? __('site.User Deleted');
  } //end of get first name

  public function getCauserModelTypeAttribute()
  {
    $causer = $this->causer;
    if ($causer instanceof Admin) {
      $causer_type = __('site.Admin');
    } elseif ($causer instanceof Customer) {
      $causer_type = __('site.Customer');
    } elseif ($causer instanceof School) {
      $causer_type = __('site.School');
    }
    return $causer_type ?? '';
  } //end of get first name


  public function scopeWhenSearch($query, $search)
  {
    return $query->when($search, function ($q) use ($search) {
      return $q->where('subject_id', $search);
    });
  } // end of scopeWhenSearch

  public function scopeWhenSchool($query)
  {
    if (request()->is('school/*') && $school_id = getAuthSchool()?->id) {
      return $query->when($school_id, function ($q) use ($school_id) {
        return $q->where('causer_type', 'App\Models\School')->where('causer_id', $school_id);
      });
    }
  } // end of scopeWhenSearch

}
