<?php

namespace App\Http\Resources;

use App\Http\Resources\TeacherResource;
use App\Http\Resources\TeacherInofResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status'=>  $this->status ,
            'total'=>  $this->total ,
            'shipping_number'=>  $this->shipping_number ,
            'customer_name'=>  $this->customer_name ,
            'customer_address'=>  $this->customer_address ,
            'customer_phone'=>  $this->customer_phone ,
            'customer_city'=>  $this->customer_city ,
            'customer_region'=>  $this->customer_region ,
            'customer_street'=>  $this->customer_street ,
            'customer_home_number'=>  $this->customer_home_number ,
            'customer_floor_number'=>  $this->customer_floor_number ,
            'payment_method'=>  $this->payment_method ,
            'payment_status'=>  $this->payment_status ,
            'promocode'=>  $this->promocode ,
            'delivery_type'=>  $this->delivery_type ,
            'delivery_fees'=>  $this->delivery_fees ,
            'promocode_value'=>  $this->promocode_value ,
            'orderDetails'=> ProductResource::collection($this->products),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,

        ] ;
    }
}
