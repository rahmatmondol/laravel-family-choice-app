<?php

namespace App\Http\Resources;

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
    $isAuth = getCurrentCustomer();
    return [
      'id' =>  $this->id,
      'full_name'  => $this->full_name,
      'email'  => $this->email,
      'phone'  => $this->phone,
      'date_time'  => $this->date_time,
      'provider' => new ProviderResource($this->provider),
      'created_at' => (string) $this->created_at,
      'updated_at' => (string) $this->updated_at,
    ];
  }
}
