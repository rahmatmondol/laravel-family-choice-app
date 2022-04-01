<?php

namespace App\Http\Resources;

use App\Http\Resources\StudentResource;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{

    public function toArray($request)
    {
        return [

            'comment'=>$this->comment ,
            'review'=> $this->review,
            'customer'=> new CustomerResource($this->customer),
            'created_at' => (string) $this->created_at,

        ] ;

    }
}
