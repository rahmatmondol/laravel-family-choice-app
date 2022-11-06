<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
  use \Astrotomic\Translatable\Translatable;
  protected $guarded = [];

  public $translatedAttributes = ['title', 'description'];
  protected $appends = ['image_path'];

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new OrderScope);
  }

  public function getImagePathAttribute()
  {
    return asset('uploads/grades/' . $this->image);
  } //end of image path attribute

  public function scopeIsActive($query, $status = null)
  {
    if ($status != null)
      return $query->where('status', (bool)$status);
  }

  public function scopeWhenSchool($query, $school_id)
  {
    return $query->when($school_id, function ($q) use ($school_id) {

      return $q->whereHas('school', function ($qu) use ($school_id) {

        return $qu->where('school_id', $school_id);
      });
    });
  } // end of

  public function scopeWhenGrade($query, $grade_id)
  {
    return $query->when($grade_id, function ($q) use ($grade_id) {

      return $q->whereHas('grade', function ($qu) use ($grade_id) {

        return $qu->where('grade_id', $grade_id);
      });
    });
  } // end of

  public function scopeWhenSearch($query, $search)
  {
    return $query->when($search, function ($q) use ($search) {

      return $q->whereTranslationLike('title', '%' . $search . '%');
    });
  } // end of scopeWhenSearch

  /////////////////// start relationships ///////////////////////////////
  public function schools()
  {
    return $this->belongsToMany(School::class, 'school_grade', 'school_id', 'grade_id')->withTranslation(app()->getLocale())->withPivot(['status']);
  }

  // public function gradeFees()
  // {
  //   return $this->hasMany(GradeFees::class,'grade_id','id')->withTranslation(app()->getLocale());
  // } // end of user

  public function getActiveGradeFees($school_id)
  {
    return GradeFees::where('grade_id',$this->id)->where('school_id',$school_id)->isActive(true)->withTranslation(app()->getLocale())->get();
    // return $this->gradeFees()->where('school_id',$school_id)->isActive(true);
  } // end of user
  /////////////////// end relationships ///////////////////////////////
}
