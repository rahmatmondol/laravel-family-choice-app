<?php

namespace App\Repositories;

use App\Models\EducationType;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\EducationTypeRepositoryInterface;

class EducationTypeRepository implements EducationTypeRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredEducationTypes($request)
  {
    return  EducationType::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllEducationTypes()
  {
    return  EducationType::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->get();
  }

  public function getEducationTypeById($educationTypeId)
  {
    $educationType = EducationType::findOrFail($educationTypeId);
    return $educationType;
  }

  public function getEducationTypeRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createEducationType($request)
  {
    $request_data = $this->getEducationTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'educationTypes/', '', '');
    } //end of if

    $educationType = EducationType::create($request_data);

    return   $educationType;
  }

  public function updateEducationType($request, $educationType)
  {
    $request_data = $this->getEducationTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'educationTypes/', $educationType->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $educationType->update($request_data);

    return true;
  }

  public function deleteEducationType($educationType)
  {
    $this->removeImage($educationType->image, 'educationTypes');
    $educationType->delete();
    return true;
  }
}
