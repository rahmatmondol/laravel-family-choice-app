<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransportationResource extends JsonResource
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
      'price'              => $this->price,
      'school_id'          => $this->school_id,
    ];
  }
}
