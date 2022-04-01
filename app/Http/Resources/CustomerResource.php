<?php

namespace App\Http\Resources;
use App\Gift;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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

            'full_name'=> $this->full_name ,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'image'=> $this->image_path,
            'firebaseToken'=> $this->firebaseToken,
            // 'status'=>(string) $this->status,
            'lat'=>(string) $this->lat,
            'lng'=>(string) $this->lng,
            'city'=> new CityResource($this->city),
            'created_at' => (string) $this->created_at,

        ];

    }
}
