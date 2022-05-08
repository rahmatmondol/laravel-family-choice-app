<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id'                  =>  $this->id,
      'title'               => $this->title,
      'address'             => $this->address,
      'description'         => $this->description,
      'fees'                => (string) $this->fees,
      'phone'               => (string)  $this->phone,
      'whatsapp'            => (string) $this->whatsapp,
      'email'               => (string) $this->email,
      'available_seats'     => (string) $this->available_seats,
      'lat'                 => (string) $this->lat,
      'lng'                 => (string) $this->lng,
      'image'               =>  $this->image_path,
      'cover'               =>  $this->cover_path,
      'can_reviewed'        =>   (bool)$this->can_reviewed,
      'is_favoried'         =>  (bool)$this->is_favoried,
      'review'              => (string)$this->review,
      'total_number_review' => (string)$this->reviews_count ?? 0,
      'educationalSubjects' => EducationalSubjectResource::collection($this->educationalSubjects),
      'educationTypes'      => EducationTypeResource::collection($this->educationTypes),
      'schoolTypes'         => SchoolTypeResource::collection($this->schoolTypes),
      'services'            => ServiceResource::collection($this->services),
      'grades'              => SchoolGradeResource::collection($this->grades),
      'types'               => TypeResource::collection($this->types),
      'gallary'             => SchoolImageResource::collection($this->schoolImages),
      // 'reviews'          => ReviewResource::collection($this->reiews),
    ];
  }
}
