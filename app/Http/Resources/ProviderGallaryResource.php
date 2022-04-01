<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderGallaryResource extends JsonResource
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
      'id' =>  $this->id,
      'type'  => $this->type,
      'file_path'  => $this->file_path,
      'created_at'=> (string) $this->created_at,
      'updated_at'=> (string) $this->updated_at,
    ];
  }
}
