<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageResource extends JsonResource
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
            'pageName'=>  $this->pageName ,
            'image'  => $this->image_path ,
            'title'  => $this->title ,
            'description'  => $this->description ,
            'created_at' => (string) $this->created_at,

        ] ;

    }
}
