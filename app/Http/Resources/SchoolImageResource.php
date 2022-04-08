<?php

namespace App\Http\Resources;

use App\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolImageResource extends JsonResource
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
      'id' => $this->id,
      'image' => $this->image_path,
    ];
  }
}
