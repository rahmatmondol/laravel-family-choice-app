<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'image'=>$this->image_path ,
            'title'=> $this->title,
            'short_description'=> $this->short_description,
            'description'=> $this->description,
            'date_time'=> $this->date_time,

        ] ; 
    }
}
