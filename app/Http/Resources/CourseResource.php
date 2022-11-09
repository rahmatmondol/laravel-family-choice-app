<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
      'id'                 =>  $this->id,
      'title'              => $this->title,
      'short_description'  => $this->short_description,
      'description'        => $this->description,
      'image'              => $this->image_path,
      'subscription'       => new SubscriptionResource($this->subscription) ,
      // 'subscription_types' => new SubscriptionTypeResource($this->subscription_types) ,
      'from_date'          => $this->from_date,
      'to_date'            => $this->to_date,
    ];
  }
}
