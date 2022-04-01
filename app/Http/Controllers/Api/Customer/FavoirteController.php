<?php

namespace App\Http\Controllers\API\Customer;

use App\Product;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;


use App\Http\Controllers\Controller;
use App\Traits\Models\FavoirteTrait;
use App\Http\Requests\FavoirteFormRequest;
use App\Http\Resources\Collection\ProductCollection;
use App\Http\Resources\Collection\ProviderCollection;

class FavoirteController  extends Controller
{

  use ResponseTrait, FavoirteTrait;

  public function toggle_favorite(FavoirteFormRequest $request)
  {

    $this->update_favorite($request->provider_id);

    return $this->sendResponse("", "");
  }

  public function favoirtes(Request $request)
  {
    $providers = $this->get_favorites();
    return $this->sendResponse(new ProviderCollection($providers), "");
  }
}
