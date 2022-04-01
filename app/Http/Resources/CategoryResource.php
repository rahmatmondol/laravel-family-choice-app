<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'  => $this->name ,
            'type'  => $this->type ,
            // 'subcategories'  => SubCategoryResource::collection($this->subcategories->where('status',1) ) ,
            // 'description'  => $this->description ,
            'image' =>  $this->image_path ,

        ] ;

    }
}
