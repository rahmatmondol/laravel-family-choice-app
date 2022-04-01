<?php

namespace App\Http\Resources;

use App\Review;
use App\Favoirte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {

        $ProductInCart   = 0 ;
        $IsProductFavoirte = 0 ;
        $ProductInCartQty = 0 ;

        if( $request->hasHeader('Authorization') ){

            if( $auth  =  auth()->guard('customer-api')->user() ){

                $ProductInCart= DB::table('cart_items')->where('product_id',$this->id)->where('cart_id',$auth->cart->id)->first();

                if($ProductInCart){
                    $ProductInCartQty   =$ProductInCart->qty;
                }

                $IsProductFavoirte= (Favoirte::where('product_id',$this->id )->where('customer_id',$auth['id'])->first() )? 1:0;

            }
        }

        return [

            'id' =>  $this->id ,
            'status'=>  $this->status ,
            'featured'=>  (bool)$this->featured ,
            'trending'=>  (bool)$this->trending ,
            'is_new'=>  (bool)$this->is_new ,
            'best_seller'=>  (bool)$this->best_seller ,
            'off_50'=>  (bool)$this->off_50 ,
            'on_sale'=>  (bool)$this->on_sale ,
            'hot_deal'=> (bool) $this->hot_deal ,
            'hot_deal_price'=> (int) $this->hot_deal_price ,
            'expire_date_hot_deal'=>  $this->expire_date_hot_deal ,
            'product_code'=>  $this->product_code ,
            'porduct_sku_code'=>  $this->porduct_sku_code ,
            'product_serial_number'=>  $this->product_serial_number ,
            'link_youtube'=>  $this->link_youtube ,
            'stock'=>  (int)$this->stock ,
            'stock_limit_alert'=>  (int)$this->stock_limit_alert ,
            'count_solid'=> (int) $this->count_solid ,
            'number_views'=> (int) $this->number_views ,
            'number_clicks'=> (int) $this->number_clicks ,
            'total_rate'=>  $this->reviews->avg('review')??0,
            'total_number_review'=>  Review::where('product_id',$this->id)->count(),
            'reviews'=> ReviewResource::collection($this->reviews) ,

            'sale_price'=> (int) $this->sale_price ,
            'discount'=>  (int)$this->discount ,
            'total'=>  (int)$this->total ,
            'total_with_currency'=>  $this->total_with_currency ,
            'image'=>  $this->image_path ,
            'category'=>  $this->category->name ,
            'subcategory'=>  $this->subcategory->name??"" ,
            'brand'=>  $this->brand->name??"" ,
            'created_by'=>  $this->created_by ,
            'updated_by'=>  $this->updated_by ,
            // 'unit'=>  $this->unit ,
            'name'  => $this->name ,
            'short_description'  => mb_convert_encoding($this->short_description, 'UTF-8'),
            'description'  => $this->description ,
            'productImages'  => ProductImageResource::collection($this->productImages)  ,
            'ProductInCart' =>   (int)($ProductInCart ? 1:0 ),
            'ProductInCartQty' =>   (int)($ProductInCart?$ProductInCart->qty:0),
            'ProductInCartColor' =>   $this->product_color_in_cart ,
            'ProductInCartTotal' =>   (int)($ProductInCart?$ProductInCart->qty*$this->total:0),
            'IsProductFavoirte' =>  (int)$IsProductFavoirte ,
            'currency' => __('site.'.config('site_options.currency')) ,

        ];

    }

}
