<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\Attachment;
use App\Scopes\OrderScope;
use App\Traits\LocationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class School extends Authenticatable
{
  use \Astrotomic\Translatable\Translatable, LocationTrait, Notifiable, SoftDeletes;
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
      if(file_exists(asset('uploads/schools/'.$this->image))){
          return asset('uploads/schools/' . $this->image);
      }else{
          return asset('uploads/schools/default.png');
      }
    // return asset('uploads/schools/' . $this->image);
  } //end of image path attribute

  public function getCoverPathAttribute()
  {
    return asset('uploads/schools/' . $this->cover);
  } //end of image path attribute

  // is_nursery_type
  public function getIsNurseryTypeAttribute()
  {
    return (bool)$this->type?->is_nursery;
  } //end of image path attribute

  // is_nursery_type
  public function getIsSchoolTypeAttribute()
  {
    return (bool)!$this->type?->is_nursery;
  } //end of image path attribute

  public function getIsFavoriedAttribute()
  {
    if ($customer = getCustomer()) {
      return  (bool) in_array($this->id, $customer->favorites->pluck('id')->toArray());
    }

    return false;
  } // end of getIsFavoredAttribute

  public function getCanReviewedAttribute()
  {
    if ($customer = getCustomer()) {
      return  (bool) in_array($this->id, $customer->reservations->where('status', 'accepted')->pluck('school_id')->toArray());
    }

    return false;
  } // end of getIsFavoredAttribute

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

  public function scopeWhenSortByReview($query)
  {
    if (request()->sortType == 'mostReview') {
      return $query->orderBy('review', 'desc');
    }
  } // end of scopeWhenSearch

//  public function scopeWhenSortByPrice($query)
//  {
//    if($type_id = request('type_id')){
//      if (request()->sortType == 'priceLH') {
//        // return $query->orderBy('fees', 'asc');
//
//        if($type_id==1){
//          return $query->whereHas('gradeFees', function ($qu)  {
//
//            return $qu->orderBy('price','asc' );
//          });
//        }
//
//        if($type_id==2){
//          return $query->whereHas('nurseryFees', function ($qu)  {
//
//            return $qu->orderBy('price','asc' );
//          });
//        }
//
//      }
//
//      if (request()->sortType == 'priceHL') {
//        // return $query->orderBy('fees', 'desc');
//
//        if($type_id==1){
//          return $query->whereHas('gradeFees', function ($qu)  {
//
//            return $qu->orderBy('price','desc' );
//          });
//        }
//
//        if($type_id==2){
//          return $query->whereHas('nurseryFees', function ($qu)  {
//
//            return $qu->orderBy('price','desc' );
//          });
//        }
//
//      }
//    }
//    else {
//
//        if (request()->sortType == 'priceLH') {
//            return $query->where(function ($q) {
//                return $q->whereHas('gradeFees', function ($qu) {
//                    return $qu->orderBy('price', 'asc');
//                })->orWhereHas('nurseryFees', function ($qu) {
//                    return $qu->orderBy('price', 'asc');
//                });
//            });
//        }
//
//        if (request()->sortType == 'priceHL') {
//            return $query->where(function ($q) {
//                return $q->whereHas('gradeFees', function ($qu) {
//                    return $qu->orderBy('price', 'desc');
//                })->orWhereHas('nurseryFees', function ($qu) {
//                    return $qu->orderBy('price', 'desc');
//                });
//            });
//        }
//        // If type_id is not provided in the request, include both gradeFees and nurseryFees
//
//    }
//  } // end of scopeWhenSearch

    public function scopeWhenSortByPrice($query)
    {
        $type_id = request('type_id');
        $sortType = request()->sortType;

        if ($type_id && ($sortType == 'priceLH' || $sortType == 'priceHL')) {
            if ($type_id == 1) {
                return $query->whereHas('gradeFees', function ($qu) use ($sortType) {
                    $qu->orderBy('price', ($sortType == 'priceLH') ? 'asc' : 'desc');
                });
            }

            if ($type_id == 2) {
                return $query->whereHas('nurseryFees', function ($qu) use ($sortType) {
                    $qu->orderBy('price', ($sortType == 'priceLH') ? 'asc' : 'desc');
                });
            }
        } else {
            return $query->where(function ($q) {
                $q->whereHas('gradeFees', function ($qu) {
                    $qu->orderBy('price', 'asc');
                })->orWhereHas('nurseryFees', function ($qu) {
                    $qu->orderBy('price', 'asc');
                });
            })->orWhere(function ($q) {
                $q->whereHas('gradeFees', function ($qu) {
                    $qu->orderBy('price', 'desc');
                })->orWhereHas('nurseryFees', function ($qu) {
                    $qu->orderBy('price', 'desc');
                });
            });
        }
    }

  public function scopeWhenFromPrice($query)
  {
    if($type_id = request('type_id')){
      if (request()->from_price != null) {

        if($type_id==1){
          return $query->whereHas('gradeFees', function ($qu)  {

            return $qu->where('price','>=',request()->from_price );
          });
        }

        if($type_id==2){
          return $query->whereHas('nurseryFees', function ($qu)  {

            return $qu->where('price','>=',request()->from_price );
          });
        }

      }
    }

  }

  public function scopeWhenToPrice($query)
  {

    if($type_id = request('type_id')){
      if (request()->to_price != null) {

        if($type_id==1){

          return $query->whereHas('gradeFees', function ($qu)  {

            return $qu->where('price','<=',request()->to_price );
          });
        }

        if($type_id==2){

          return $query->whereHas('nurseryFees', function ($qu)  {

            return $qu->where('price','<=',request()->to_price );
          });
        }

      }
    }
  }

  public function scopeWhenTypes($query)
  {
    return $query->when(request()->type_id != null, function ($typeQuery) {
      $typeQuery->whereIn('type_id', (array)request()->type_id);
    });
  }

  public function scopeWhenGrades($query)
  {
    $grades = request()->grade_id;

    return $query->when($grades, function ($q) use ($grades) {

      return $q->whereHas('grades', function ($qu) use ($grades) {

        return $qu->whereIn('grade_id', (array)$grades);
      });
    });
  }

  public function scopeWhenSubscriptions($query)
  {
    $subscriptions = request()->subscription_id;

    return $query->when($subscriptions, function ($q) use ($subscriptions) {

      return $q->whereHas('subscriptions', function ($qu) use ($subscriptions) {

        return $qu->whereIn('subscription_id', (array)$subscriptions);
      });
    });
  }

  public function scopeWhenEducationalSubjects($query)
  {
    $educationalSubjects = request()->educational_subject_id;
    return $query->when($educationalSubjects, function ($q) use ($educationalSubjects) {

      return $q->whereHas('educationalSubjects', function ($qu) use ($educationalSubjects) {

        return $qu->whereIn('educational_subject_id', (array)$educationalSubjects);
      });
    });
  }

  public function scopeWhenEducationTypes($query)
  {
    $educationTypes = request()->education_type_id;

    return $query->when($educationTypes, function ($q) use ($educationTypes) {

      return $q->whereHas('educationTypes', function ($qu) use ($educationTypes) {

        return $qu->whereIn('education_type_id', (array)$educationTypes);
      });
    });
  }

  public function scopeWhenSchoolTypes($query)
  {
    $schoolTypes = request()->school_type_id;

    return $query->when($schoolTypes, function ($q) use ($schoolTypes) {

      return $q->whereHas('schoolTypes', function ($qu) use ($schoolTypes) {

        return $qu->whereIn('school_type_id', (array)$schoolTypes);
      });
    });
  }

  public function scopeWhereNursery($query, $get_nurseries = null)
  {
    return $query->when($get_nurseries !== null, function ($query1) use ($get_nurseries) {
      $query1->whereHas('type', function ($query2) use ($get_nurseries) {
        $query2->isNursery($get_nurseries);
      });
    });
  }
  /////////////////// end scopes ///////////////////////////////

  /////////////////// start relationships ///////////////////////////////
  public function schoolImages()
  {
    return $this->hasMany(SchoolImage::class);
  } // end of user

  public function reservations()
  {
    return $this->hasMany(Reservation::class);
  } //end fo category

  public function courses()
  {
    return $this->hasMany(Course::class)->withTranslation(app()->getLocale());
  } // end of user

  public function activeCourses()
  {
    return $this->hasMany(Course::class);
  } // end of user

  public function nurseryFees()
  {
    return $this->hasMany(NurseryFees::class,'school_id','id')->withTranslation(app()->getLocale());
  } // end of user

  public function activeNurseryFees()
  {
    return $this->nurseryFees()->isActive(true);
  } // end of user

  public function paidServices()
  {
    return $this->hasMany(PaidService::class)->withTranslation(app()->getLocale());
  } // end of user

  public function activePaidServices()
  {
    return $this->paidServices()->isActive(true);
  } // end of user

  public function transportations()
  {
    return $this->hasMany(Transportation::class)->withTranslation(app()->getLocale());
  } // end of user

  public function activeTransportations()
  {
    return $this->transportations()->isActive(true);
  } // end of user

  public function attachments()
  {
    return $this->hasMany(Attachment::class);
  } // end of user

  public function grades()
  {
    return $this->belongsToMany(Grade::class, 'school_grade', 'school_id', 'grade_id')->withTranslation(app()->getLocale())->withPivot([ 'status'])->withoutGlobalScope(new OrderScope);
  }

  public function activeGrades()
  {
    return $this->grades()->wherePivot('status', Status::Active->value);
  }

  public function gradeFees()
  {
    return $this->hasMany(GradeFees::class, 'school_id', 'id')->withTranslation(app()->getLocale())->withoutGlobalScope(new OrderScope);
  }

  public function activeGradeFees()
  {
    return $this->gradeFees()->isActive(true);
  }

  public function subscriptions()
  {
    return $this->belongsToMany(Subscription::class, 'nursery_subscription')->withTranslation(app()->getLocale())->withPivot(['status'])->withoutGlobalScope(new OrderScope);
  }

  public function activeSubscriptions()
  {
    return $this->subscriptions()->wherePivot('status', Status::Active->value);
  }

  public function educationalSubjects()
  {
    return $this->belongsToMany(EducationalSubject::class, 'school_education_subject', 'school_id', 'educational_subject_id')->withTranslation(app()->getLocale())->withoutGlobalScope(new OrderScope);
  }

  public function educationTypes()
  {
    return $this->belongsToMany(EducationType::class, 'school_education_type', 'school_id', 'education_type_id')->withTranslation(app()->getLocale())->withoutGlobalScope(new OrderScope);
  }

  public function schoolTypes()
  {
    return $this->belongsToMany(SchoolType::class, 'school_school_type', 'school_id', 'school_type_id')->withTranslation(app()->getLocale())->withoutGlobalScope(new OrderScope);
  }

  public function type()
  {
    return $this->belongsTo(Type::class);
  }

  public function services()
  {
    return $this->belongsToMany(Service::class, 'school_service', 'school_id', 'service_id')->withTranslation(app()->getLocale())->withoutGlobalScope(new OrderScope);
  }

  public function favorites()
  {
    return $this->belongsToMany(
      School::class,
      'favorites',
    );
  }

  public function reviews()
  {
    return $this->hasMany(Review::class);
  } //end fo category

  /////////////////// end relationships ///////////////////////////////
}
