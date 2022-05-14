<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
  use HasFactory;
  use \Astrotomic\Translatable\Translatable;
  protected $guarded = [];

  public $translatedAttributes = ['title', 'description', 'short_description'];
  protected $appends = ['image_path'];

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new OrderScope);
  }

  public function getImagePathAttribute()
  {
    return asset('uploads/courses/' . $this->image);
  } //end of image path attribute

  ////////////////// start scopes ////////////////////////////////
  public function scopeIsActive($query, $status = null)
  {
    if ($status != null)
      return $query->where('status', (bool)$status);
  }

  public function scopeWhenSearch($query, $search)
  {
    return $query->when($search, function ($q) use ($search) {

      return $q->whereTranslationLike('title', '%' . $search . '%');
    });
  } // end of scopeWhenSearch

  public function scopeWhenSchool($query)
  {
    $school_id = request()->school_id;

    return $query->when($school_id, function ($q) use ($school_id) {

      return $q->whereHas('school', function ($qu) use ($school_id) {

        return $qu->whereIn('school_id', (array)$school_id);
      });
    });
  } // end of
  ////////////////// start scopes ////////////////////////////////

  public function school()
  {
    return $this->belongsTo(School::class);
  } //end fo category

  public function reservations()
  {
    return $this->hasMany(Reservation::class);
  } //end fo category

}
