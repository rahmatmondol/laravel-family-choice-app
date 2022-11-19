<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionTypeResource extends JsonResource
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
      'id'              => $this->id,
      'title'           => $this->title,
      'appointment'     => $this->appointment,
      'number_of_days'  => $this->number_of_days,
      'price'           => $this->price,
      'type'            => $this->type,
      // 'subscription'    => new SubscriptionResource($this->subscription) ,
    ];
  }
}
