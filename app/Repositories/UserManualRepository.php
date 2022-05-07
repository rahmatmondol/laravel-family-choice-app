<?php

namespace App\Repositories;

use App\Models\UserManual;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\UserManualRepositoryInterface;

class UserManualRepository implements UserManualRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredUserManuals($request)
  {
    return  UserManual::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getUserManuals($request)
  {
    return  UserManual::isActive(true)
      // ->latest()
      ->paginate($request->perPage ?? 20);
  }

  public function getUserManualById($sliderId)
  {
    $slider = UserManual::findOrFail($sliderId);
    return $slider;
  }

  public function getUserManualRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createUserManual($request)
  {
    $request_data = $this->getUserManualRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'sliders/', '', '');
    } //end of if

    $slider = UserManual::create($request_data);

    return   $slider;
  }

  public function updateUserManual($request, $slider)
  {
    $request_data = $this->getUserManualRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'sliders/', $slider->image);
    } //end of if

    $slider->update($request_data);

    return true;
  }

  public function deleteUserManual($slider)
  {
    $this->removeImage($slider->image, 'sliders');
    $slider->delete();
    return true;
  }
}
