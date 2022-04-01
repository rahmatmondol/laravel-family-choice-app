<?php

namespace App\Http\Resources\Collection;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubCategoryCollection extends ResourceCollection
{

  public $collects = 'App\Http\Resources\SubCategoryResource';

  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */

  public function toArray($request)
  {
    return [

      'data' => $this->collection,
      "meta" => [

        "current_page" => $this->currentPage(),
        "last_page" =>  $this->lastPage(),
        "per_page" =>  $this->perPage(),
        "hasMorePages" =>  $this->hasMorePages(),
        "total" =>  $this->total(),

      ]

    ];
  }
}
