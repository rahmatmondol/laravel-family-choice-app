<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GiftResource extends JsonResource
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
            'type'  => $this->type ,
            'title'  => $this->title ,
            'gift_value'  => $this->gift_value ,

        ] ;

    }
}
