<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
  use \Astrotomic\Translatable\Translatable;
  protected $guarded = [];

  public $translatedAttributes = ['title'];
  protected $appends = ['image_path'];

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new OrderScope);
  }

  public function getTemplateFilePathAttribute()
  {
    if ($this->template_file != null && File::exists(public_path('uploads/attachments/' . $this->template_file))) {
      return asset('uploads/attachments/' . $this->template_file);
    }
  } //end of get image path

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

  public function scopeWhenSchool($query,$school_id=null)
  {
    $school_id = getAuthSchool() ? getAuthSchool()->id : $school_id;
    return $query->when($school_id, function ($q) use ($school_id) {

      return $q->whereHas('school', function ($qu) use ($school_id) {

        return $qu->whereIn('school_id', (array)$school_id);
      });
    });
  } // end of

  public function school()
  {
    return $this->belongsTo(School::class);
  } //end fo category

}
