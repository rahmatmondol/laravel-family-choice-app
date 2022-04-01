<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'image' => $this->image_path ,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description'=> str_replace( "\t", '', str_replace(PHP_EOL, '', preg_replace("/&nbsp;/", '', strip_tags(htmlspecialchars_decode( $this->description ) )))) ,
            'created_at' => (string) $this->created_at,
        ] ; 

    }
}
