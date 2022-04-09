<?php

namespace App\Http\Controllers\API\Customer;

use App\Product;

use App\Models\School;
use Illuminate\Http\Request;


use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FavoriteFormRequest;
use App\Http\Resources\Collection\SchoolCollection;
use App\Http\Resources\Collection\ProviderCollection;

class FavoirteController  extends Controller
{

  use ResponseTrait;

  public function toggle_favorite(FavoriteFormRequest $request)
  {
    $school = School::find($request->school_id);
    $customer = getCustomer();
    $school->is_favoried
      ? $customer->favorites()->detach($school->id)
      : $customer->favorites()->attach($school->id);

    return $this->sendResponse("", "");
  }

  public function favorites(Request $request)
  {
    $schools = getCustomer()->favorites()->latest()->paginate($request->perPage ?? 20);
    return $this->sendResponse(new SchoolCollection($schools), "");
  }
}
