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
      'educationalSubjects' => EducationalSubjectResource::collection($this->whenLoaded('educationalSubjects')),
      'educationTypes'      => EducationTypeResource::collection($this->whenLoaded('educationTypes')),
      'schoolTypes'         => SchoolTypeResource::collection($this->whenLoaded('schoolTypes')),
      'services'            => ServiceResource::collection($this->whenLoaded('services')),
      'grades'              => $this->when($this->is_school_type, SchoolGradeResource::collection($this->whenLoaded('activeGrades'))),
      'subscriptions'       => $this->when($this->is_nursery_type, SubscriptionResource::collection($this->whenLoaded('activeSubscriptions'))),
      'courses'             => $this->when($this->is_nursery_type, CourseResource::collection($this->whenLoaded('activeCourses'))),
      'type'                => new TypeResource($this->type),
      'gallary'             => SchoolImageResource::collection($this->whenLoaded('schoolImages')),
      'nursery_fees'        => $this->when($this->is_nursery_type, NurseryFeesResource::collection($this->whenLoaded('activeNurseryFees'))),
      'paid_services'       => PaidServiceResource::collection($this->whenLoaded('activePaidServices')),
      'transportations'     => TransportationResource::collection($this->whenLoaded('activeTransportations')),
    ];
  }
}
