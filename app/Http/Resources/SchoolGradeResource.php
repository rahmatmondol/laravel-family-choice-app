<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolGradeResource extends JsonResource
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
      'id'                      =>  $this->id,
      'title'                   => $this->title,
      'fees'                    => (string)$this->pivot->fees,
      'administrative_expenses' => (string)$this->pivot->administrative_expenses,
    ];
  }
}
