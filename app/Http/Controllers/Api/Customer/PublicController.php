<?php

namespace App\Http\Controllers\Api\Customer;


use App\Models\City;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\SliderResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StaticPageResource;
use App\Interfaces\CityRepositoryInterface;
use App\Http\Resources\Collection\CityCollection;

class PublicController extends Controller
{
  use ResponseTrait;

  public function __construct(
    private CityRepositoryInterface $cityRepository
  ) {
  } //end of constructor
  public function cities(Request $request)
  {
    $cities = $this->cityRepository->getAllCities();

    return $this->sendResponse(CityResource::collection($cities), "");
  }

  // public function getCity(Request $request)
  // {

  //   $validator = Validator::make($request->all(), [
  //     'lat' => ['required', 'regex:/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
  //     'lng' => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
  //   ]);

  //   if ($validator->fails()) {
  //     return $this->sendError(' ', $validator->errors());
  //   }

  //   $city = City::WhenLocation()->first();

  //   return $this->sendResponse(new CityResource($city), "");
  // }


  public function sliders(Request $request)
  {

    return $this->sendResponse(SliderResource::collection(Slider::latest()->get()), "");
  }

  public function staticPages(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'pageName' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError(' ', $validator->errors());
    }

    $page = Page::where('pageName', $request->pageName)->firstOrFail();

    return $this->sendResponse(new StaticPageResource($page), "");
  }

  // public function blogs(Request $request)
  // {

  //   return $this->sendResponse(BlogResource::collection(Blogs::latest()->get()), "");
  // }
  public function contactUs(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'phone' => 'required',
      'message' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError(' ', $validator->errors());
    }

    $city = Inbox::create($request->all());
    $message = __('site.Congratulation! Your Message Is Sent Successfully');
    // QuickSendEmail($request->email, $message);


    return $this->sendResponse("", "");
  }
}
