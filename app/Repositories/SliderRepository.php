<?php

namespace App\Repositories;

use App\Models\Slider;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\SliderRepositoryInterface;

class SliderRepository implements SliderRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredSliders($request)
  {
    return  Slider::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getSliders($request)
  {
    return  Slider::isActive(true)
      ->latest()
      ->paginate($request->perPage ?? 20);
  }

  public function getSliderById($sliderId)
  {
    $slider = Slider::findOrFail($sliderId);
    return $slider;
  }

  public function getSliderRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column', 'school_id', 'link'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createSlider($request)
  {
    $request_data = $this->getSliderRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'sliders/', '', '');
    } //end of if

    $slider = Slider::create($request_data);

    return   $slider;
  }

  public function updateSlider($request, $slider)
  {
    $request_data = $this->getSliderRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'sliders/', $slider->image);
    } //end of if

    $slider->update($request_data);

    return true;
  }

  public function deleteSlider($slider)
  {
    $this->removeImage($slider->image, 'sliders');
    $slider->delete();
    return true;
  }
}
