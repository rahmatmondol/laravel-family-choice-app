<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            
            'id'=>  $this->id , 
            'email'  => $this->email , 
            'name'=>$this->name , 
            'address'=>$this->address , 
            'premium'=> $this->premium , 
            'phone'  => $this->phone , 
            'city_id'  => $this->city_id , 
            'state_id'  => $this->state_id , 
            'category_id'  => $this->category_id , 
            'lat'  => $this->lat , 
            'lng'  => $this->lng , 
            'image'=>$this->image_path,

        ] ;
    }
}
