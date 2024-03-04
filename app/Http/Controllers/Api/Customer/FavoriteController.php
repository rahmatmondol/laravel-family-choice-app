<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Favorite;
use App\Models\School;
use Illuminate\Http\Request;


use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FavoriteFormRequest;
use App\Http\Resources\Collection\SchoolCollection;

class FavoriteController  extends Controller
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
    $schools = getCustomer()->favorites()->withTranslation()->with(['type'])->latest()->paginate($request->perPage ?? 20);
    return $this->sendResponse(new SchoolCollection($schools), "");
  }

  public function delete($id)
  {
      $data = Favorite::where('school_id',$id)->first();

      if(empty($data)){
          return $this->sendResponse('','favorite is not exist');

      }
//      return $data;
      $data->delete();
      return $this->sendResponse('','favorite delete successfull');
  }
}
