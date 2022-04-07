<?php

namespace App\Repositories;

use App\Models\City;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredCities($request)
  {
    return  City::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 30);
  }

  public function getAllCities()
  {
    return  City::whenLocation()->get();
  }

  public function getCityById($sliderId)
  {
    $slider = City::findOrFail($sliderId);
    return $slider;
  }

  public function getCityRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column', 'lat', 'lng'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createCity($request)
  {
    $request_data = $this->getCityRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'cities/', '', '');
    } //end of if

    $slider = City::create($request_data);

    return   $slider;
  }

  public function updateCity($request, $slider)
  {
    $request_data = $this->getCityRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'cities/', $slider->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $slider->update($request_data);

    return true;
  }

  public function deleteCity($slider)
  {
    $this->removeImage($slider->image, 'cities');
    $slider->delete();
    return true;
  }
}
