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
    // dd($this->reservationChildren);
    return [
      'id' =>  $this->id,
      'parent_name'  => $this->parent_name,
      'address'  => $this->address,
      'identification_number'  => $this->identification_number,
      'total_fees'  => (string)$this->total_fees,
      'reason_of_refuse'  => $this->reason_of_refuse,
      'status'  => $this->status,
      'payment_status'  => $this->payment_status,
      'school' => new LightSchoolResource($this->school),
      'child' => new ChildResource($this->child),
      'created_at' => (string) $this->created_at,
      'updated_at' => (string) $this->updated_at,
    ];
  }
}
