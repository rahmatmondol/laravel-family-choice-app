<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait LocationTrait
{

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
