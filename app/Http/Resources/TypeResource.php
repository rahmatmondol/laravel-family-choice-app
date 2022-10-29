<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
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
      'id'          =>  $this->id,
      'title'       => $this->title,
      'is_nursery'  =>  (bool)$this->is_nursery,
    ];
  }
}
