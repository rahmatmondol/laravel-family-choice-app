<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{

  public function toArray($request)
  {
    $school = $this->school;
    return [
      'comment'               => $this->comment,
      'follow_up'             => $this->follow_up,
      'quality_of_education'  => $this->quality_of_education,
      'cleanliness'           => $this->cleanliness,
      'customer_id'           => $this->customer_id,
      'school' => [
        'id'      => $school->id,
        'title'   => $school->title,
        'address' => $school->address,
        'image'   => $school->image_path,
      ],
      'created_at' => (string) $this->created_at,
    ];
  }
}
