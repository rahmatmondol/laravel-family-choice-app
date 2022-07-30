<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\School;
use Illuminate\Http\Request;


use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Api\FavoriteFormRequest;
use App\Http\Resources\Collection\SchoolCollection;

class FavoirteController  extends BaseController
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
