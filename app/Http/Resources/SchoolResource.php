<?php

namespace App\Http\Resources;

use App\Models\NurseryFees;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id'                  => $this->id,
      'title'               => $this->title,
      'address'             => $this->address,
      'description'         => $this->description,
      'fees'                => (string) $this->fees,
      'phone'               => (string)  $this->phone,
      'whatsapp'            => (string) $this->whatsapp,
      'email'               => (string) $this->email,
      'available_seats'     => (string) $this->available_seats,
      'total_seats'         => (string) $this->total_seats,
      'lat'                 => (string) $this->lat,
      'lng'                 => (string) $this->lng,
      'image'               => $this->image_path,
      'cover'               => $this->cover_path,
      'is_nursery'          => (bool)$this->is_nursery_type,
      'can_reviewed'        => (bool)$this->can_reviewed,
      'is_favoried'         => (bool)$this->is_favoried,
      'review'              => (string)$this->review,
      'total_number_review' => (string)$this->reviews_count ?? 0,
      'educationalSubjects' => EducationalSubjectResource::collection($this->educationalSubjects),
      'educationTypes'      => EducationTypeResource::collection($this->educationTypes),
      'schoolTypes'         => SchoolTypeResource::collection($this->schoolTypes),
      'services'            => ServiceResource::collection($this->services),
      'grades'              => $this->when($this->is_school_type, SchoolGradeResource::collection($this->activeGrades)),
      'subscriptions'       => $this->when($this->is_nursery_type, SubscriptionResource::collection($this->activeSubscriptions)),
      'type'                => new TypeResource($this->type),
      'gallary'             => SchoolImageResource::collection($this->schoolImages),
      'nursery_fees'        => $this->when($this->is_nursery_type, NurseryFeesResource::collection($this->activeNurseryFees)),
      'paid_services'       => PaidServiceResource::collection($this->activePaidServices),
      'transportations'     => TransportationResource::collection($this->activeTransportations),
    ];
  }
}
