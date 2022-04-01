<?php

namespace App\Http\Resources;

use App\Shop;
use App\Customer;
use App\CustomerShopInbox;
use App\Http\Resources\ShopResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxContentResource extends JsonResource
{

    public function toArray($request)
    {

        return [

            'id'=> $this->id,
            'message'     => $this->message ,
            'image'     => $this->image_path  ,
            'shop'=>  new ShopResource( Shop::find( $this->shop_id ) ),
            'customer'=>   Customer::find( $this->customer_id ),
            'created_at'  =>(string) $this->created_at ,

        ];
        
    }

}
