<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;

class SchoolType extends Model
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
    return asset('uploads/sliders/' . $this->image);
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
  public function schools()
  {
    return $this->belongsToMany(SchoolType::class, 'school_types', 'school_id', 'school_type_id')->withTranslation(app()->getLocale());
  }
}
