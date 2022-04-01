<?php

namespace App\Http\Resources;

use App\Http\Resources\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
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
            'fast_price'  => $this->fast_price ,
            'slow_price'  => $this->slow_price ,
            'city'  => new CityResource($this->city)  ,

        ] ;

    }
}
