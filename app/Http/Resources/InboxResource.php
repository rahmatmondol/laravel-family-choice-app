<?php

namespace App\Http\Resources;

use App\Shop;
use App\CustomerShopInbox;
use App\Http\Resources\ShopResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxResource extends JsonResource
{

    public function toArray($request)
    {

        $inbox = CustomerShopInbox::where( 'owner' , $request->owner )->where( 'customer_id' , $request->user()['id'])->where( 'shop_id' , $this->shop_id )->orderBy('id','desc')->first(); 

        return [
            
            'id'=> $inbox->id,
            'owner' => $inbox->owner,
            'message'     => $inbox->message ,
            'shop'=>  new ShopResource( Shop::find( $inbox->shop_id ) ),
            'created_at'  => (string) $inbox->created_at ,
        
        ];
        
    }

}
