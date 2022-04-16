<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildAttachmentResource extends JsonResource
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
      'id'         =>  $this->id,
      'title'      =>  $this->attachment,
      'attachment' =>  $this->attachment_path,
    ];
  }
}
