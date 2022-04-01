<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $isAuth = getCurrentCustomer();
    return [
      'id' =>  $this->id,
      'full_name'  => $this->full_name,
      'email'  => $isAuth? $this->email: '',
      'phone'  => $isAuth? $this->phone: '',
      'lat'  => $this->lat,
      'lng'  => $this->lng,
      'is_favored'  => (bool) $this->is_favored,
      'review'  => $this->review,
      'total_number_review'  => $this->total_number_review,
      // 'category_id'  => $this->category_id,
      // 'subcategory_id'  => $this->subcategory_id,
      // 'city_id'  => $this->city_id,
      'category'=>new CategoryResource($this->category),
      'subcategory'=>new SubCategoryResource($this->subcategory),
      'city'=>new CityResource($this->city),
      'image' =>  $this->image_path,
    ];
  }
}
