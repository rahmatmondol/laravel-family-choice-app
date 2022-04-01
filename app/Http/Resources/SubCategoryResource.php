<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    
    public function toArray($request)
    {
        
        return [
            
            'id'=>  $this->id , 
            'name'  => $this->name , 
            'category_id' =>  $this->category_id ,
            'image' =>  $this->image_path ,

        ] ;
        
    }
}
