<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id'                =>  $this->id,
      'title'             => $this->title,
      'address'           => $this->address,
      'description'       => $this->description,
      'fees'              => (string) $this->fees,
      'phone'             => (string)  $this->phone,
      'whatsapp'          => (string) $this->whatsapp,
      'email'             => (string) $this->email,
      'available_seats'   => (string) $this->available_seats,
      'image'             =>  $this->image_path,
      // 'can_reviewed'          =>   (bool)$this->can_reviewed,
      // 'is_favoired'          =>  (bool)$this->is_favoired,
      // 'review'          => (string)$this->review,
      // 'total_number_review' => (string)$this->reviews_count ?? 0,
      // 'gallary' => SchoolImageResource::collection($this->productImages),
      // 'reviews' => ReviewResource::collection($this->reiews),
    ];
  }
}
