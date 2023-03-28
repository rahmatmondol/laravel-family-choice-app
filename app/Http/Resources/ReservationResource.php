<?php

namespace App\Http\Resources;

use App\Http\Resources\ChildResource;
use App\Http\Resources\LightSchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id'                         => $this->id,
      'partial_payment_options'    => $this->partial_payment_options,
      'partial_payment_info'       => $this->partial_payment_info,
      'remaining_payment_options'  => $this->remaining_payment_options,
      'remaining_payment_info'     => $this->remaining_payment_info,
      'parent_name'                => $this->parent_name,
      'parent_phone'               => $this->parent_phone,
      'parent_date_of_birth'       => $this->parent_date_of_birth,
      'address'                    => $this->address,
      'identification_number'      => $this->identification_number,
      'total_fees'                 => (string)$this->total_fees,
      'reason_of_refuse'           => $this->reason_of_refuse,
      'status'                     => $this->status,
      'payment_status'             => $this->payment_status,
      'school'                     => new LightSchoolResource($this->school),
      'child'                      => new ChildResource($this->child),
      'created_at'                 => (string) $this->created_at,
      'updated_at'                 => (string) $this->updated_at,
    ];
  }
}
