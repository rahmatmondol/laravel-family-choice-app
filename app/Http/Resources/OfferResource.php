<?php

namespace App\Http\Resources;

use App\Http\Resources\ProviderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'title'  => $this->title ,
            'description'  => $this->description ,
            'provider'  =>  new ProviderResource($this->provider ),
            'category'  => new CategoryResource($this->category)  ,
            // 'old_price'  => $this->old_price ,
            // 'new_price'  => $this->new_price ,
            'image'  => $this->image_path ,

        ] ;
    }
}
