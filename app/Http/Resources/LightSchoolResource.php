<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LightSchoolResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id'                  =>  $this->id,
      'title'               => $this->title,
      'address'               => $this->address,
      'is_nursery'          => (bool)$this->is_nursery_type,
      'image'               =>  $this->image_path,
    ];
  }
}
