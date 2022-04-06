<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
  use \Astrotomic\Translatable\Translatable;
  protected $guarded = [];

  public $translatedAttributes = ['title', 'address', 'description'];
  protected $appends = ['image_path'];

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new OrderScope);
  }

  public function getImagePathAttribute()
  {
    return asset('uploads/schools/' . $this->image);
  } //end of image path attribute

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

  /////////////////// start relationships ///////////////////////////////
  public function schoolImages()
  {
    return $this->hasMany(SchoolImage::class);
  } // end of user

  public function courses()
  {
    return $this->hasMany(Course::class);
  } // end of user

  public function grades()
  {
    return $this->belongsToMany(Grade::class, 'school_grade', 'school_id', 'grade_id')->withTranslation(app()->getLocale())->withPivot(['administrative_expenses', 'fees']);
  }

  public function educationalSubjects()
  {
    return $this->belongsToMany(EducationalSubject::class, 'school_education_subject', 'school_id', 'educational_subject_id')->withTranslation(app()->getLocale());
  }

  public function educationTypes()
  {
    return $this->belongsToMany(EducationType::class, 'school_education_type', 'school_id', 'education_type_id')->withTranslation(app()->getLocale());
  }

  public function schoolTypes()
  {
    return $this->belongsToMany(SchoolType::class, 'school_school_type', 'school_id', 'school_type_id')->withTranslation(app()->getLocale());
  }

  public function types()
  {
    return $this->belongsToMany(SchoolType::class, 'school_type', 'school_id', 'type_id')->withTranslation(app()->getLocale());
  }
  /////////////////// end relationships ///////////////////////////////
}
