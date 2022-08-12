<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{

  public function toArray($request)
  {
    $customer = $this->customer;

    return [
      'comment'               => $this->comment,
      'follow_up'             => $this->follow_up,
      'quality_of_education'  => $this->quality_of_education,
      'cleanliness'           => $this->cleanliness,
      'avg'                   => doubleval(number_format($this->avg,2)),
      'customer'              => [
        'full_name' => $customer->full_name,
        'image' => $customer->image_path,
      ],
      'school' => new LightSchoolResource($this->school),
      'created_at' => (string) $this->created_at,
    ];
  }
}
