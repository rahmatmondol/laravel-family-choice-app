<?php

namespace App\Http\Resources;

use App\City;
use App\State;
use App\Category;
use App\Subcategory;
use App\shopAacceptShortlist;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortListResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            
            'id'=>  $this->id , 
            'description'=>  $this->description , 
            'image'  => $this->image_path , 
            'category_name'  =>  Category::find($this->category_id)->name??""  , 
            'subcategory_name'  =>   Subcategory::find( $this->subcategory_id )->name ??"" , 
            'city_name'  =>  City::find($this->city_id)->name  , 
            'state_name'  => State::find($this->state_id)->name  , 
            'accepted_by_shop'=> shopAacceptShortlist::where('shortlist_id',$this->id)->count(),
            'lat'  => $this->lat , 
            'lng'  => $this->lng ,
            'created_at' => (string) $this->created_at,    

        ] ;
        
    }
}
