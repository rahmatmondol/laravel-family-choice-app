<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class City extends Model
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
    return asset('uploads/citie/' . $this->image);
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

  public function scopeWhenLocation($query)
  {
    $latitude = request('lat');
    $longitude = request('lng');

    return $query->when($latitude != null && $longitude != null, function ($q) use ($latitude, $longitude) {

      return $q->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
      * cos(radians(lat)) * cos(radians(lng) - radians(" . $longitude . "))
      + sin(radians(" . $latitude . ")) * sin(radians(lat))) AS distance"))
        ->orderBy('distance', 'asc');
    });
  } // end of scopeWhenCategory

}
