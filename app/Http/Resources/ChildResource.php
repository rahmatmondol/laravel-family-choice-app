<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    // ReservationAttachment::where('id',$this->)
    // dd($this->attachments);
    return [
      'id'            =>  $this->id,
      'child_name'    => $this->child_name,
      'date_of_birth' => $this->date_of_birth,
      'total_fees'    => (string)$this->total_fees,
      'gender'        => $this->gender,
      'grade'         => new GradeResource($this->grade),
      'attachments'   => ChildAttachmentResource::collection($this->attachments),
      'created_at'    => (string) $this->created_at,
      'updated_at'    => (string) $this->updated_at,
    ];
  }
}
