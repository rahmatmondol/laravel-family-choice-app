<?php

namespace App\Models;

use App\Scopes\OrderScope;
use App\Traits\LocationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
  use \Astrotomic\Translatable\Translatable, LocationTrait;

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

  /////////////////// start scopes ///////////////////////////////
  public function scopeIsActive($query, $status = null)
  {
    if ($status != null)
      return $query->where('status', (bool)$status);
  }

  public function scopeWhenSearch($query)
  {
    $search = request()->search;
    return $query->when($search, function ($q) use ($search) {

      return $q->whereTranslationLike('title', '%' . $search . '%');
    });
  } // end of scopeWhenSearch

  public function scopeWhenSortByName($query)
  {
    if (in_array(request()->sortType, ['nameAZ', 'nameZA'])) {
      return $query->orderByTranslation('title', request()->sortType == 'nameAZ' ? 'asc' : 'desc');
    }
  } // end of scopeWhenSearch

  public function scopeWhenFromPrice($query)
  {
    if (request()->from_price != null) {
      return $query->where('fees', '>=', request()->from_price);
    }
  } // end of

  public function scopeWhenToPrice($query)
  {
    if (request()->to_price != null) {
      return $query->where('fees', '<=', request()->to_price);
    }
  } // end of

  public function scopeWhenTypes($query)
  {
    $type_id = request()->type_id;

    return $query->when($type_id, function ($q) use ($type_id) {

      return $q->whereHas('types', function ($qu) use ($type_id) {

        return $qu->whereIn('grade_id', (array)$type_id);
      });
    });
  } // end of

  public function scopeWhenGrades($query)
  {
    $grades = request()->grade_id;

    return $query->when($grades, function ($q) use ($grades) {

      return $q->whereHas('grades', function ($qu) use ($grades) {

        return $qu->whereIn('grade_id', (array)$grades);
      });
    });
  } // end of

  public function scopeWhenEducationalSubjects($query)
  {
    $educationalSubjects = request()->educational_subject_id;

    return $query->when($educationalSubjects, function ($q) use ($educationalSubjects) {

      return $q->whereHas('educationalSubjects', function ($qu) use ($educationalSubjects) {

        return $qu->whereIn('educational_subject_id', (array)$educationalSubjects);
      });
    });
  } // end of

  public function scopeWhenEducationTypes($query)
  {
    $educationTypes = request()->education_type_id;
    // $educationTypes = [1,2,3];

    return $query->when($educationTypes, function ($q) use ($educationTypes) {

      return $q->whereHas('educationTypes', function ($qu) use ($educationTypes) {

        return $qu->whereIn('education_type_id', (array)$educationTypes);
      });
    });
  } // end of

  public function scopeWhenSchoolTypes($query)
  {
    $schoolTypes = request()->school_type_id;

    return $query->when($schoolTypes, function ($q) use ($schoolTypes) {

      return $q->whereHas('schoolTypes', function ($qu) use ($schoolTypes) {

        return $qu->whereIn('school_type_id', (array)$schoolTypes);
      });
    });
  } // end of
  /////////////////// end scopes ///////////////////////////////

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
