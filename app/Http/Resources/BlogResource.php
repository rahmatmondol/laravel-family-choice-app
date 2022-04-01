<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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

            'title'=>  $this->title ,
            'short_description'=>  $this->short_description ,
            'description'=>  $this->description ,
            'title'=>  $this->title ,
            'image'=>$this->image_path,
            'created_at' => (string) $this->created_at,

        ] ;
    }
}
