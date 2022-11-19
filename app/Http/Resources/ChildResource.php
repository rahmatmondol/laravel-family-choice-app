<?php

namespace App\Http\Resources;

use App\Models\SubscriptionType;
use App\Models\Transportation;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $isSchool  = $this->reservation->school?->is_school_type;
    $isNursery = $this->reservation->school->is_nursery_type;
    if($this->transportation instanceof Transportation) { $this->transportation->price = $this->transportation_price; }
    if($this->subscription_type instanceof SubscriptionType) { $this->subscription_type->price = $this->subscription_type_price; }
    return [
      'id'                      => $this->id,
      'child_name'              => $this->child_name,
      'date_of_birth'           => $this->date_of_birth,
      'transportation'          => $this->when($this->transportation,new TransportationResource($this->transportation)) ,
      'grade'                   => $this->when($isSchool,new GradeResource($this->grade)),
      'course'                  => $this->when($this->course?->school?->is_nursery_type,new CourseResource($this->course)),
      'subscription_type'       => $this->when($isNursery,new SubscriptionTypeResource($this->subscription_type)),
      'grade_fees'              => $this->when($isSchool,ReservationGradeFeesResource::collection($this->reservation?->gradeFees)),
      'nursery_fees'            => $this->when($isNursery,ReservationNurseryFeesResource::collection($this->reservation?->nurseryFees)),
      'paid_services'           => $this->when($this->reservation?->paidServices,ReservationPaidServiceResource::collection($this->reservation?->paidServices)),
      'gender'                  => $this->gender,
      'attachments'             => ChildAttachmentResource::collection($this->attachments),
      'created_at'              => (string) $this->created_at,
      'updated_at'              => (string) $this->updated_at,
    ];
  }
}
