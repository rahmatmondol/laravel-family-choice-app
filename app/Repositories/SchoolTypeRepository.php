<?php

namespace App\Repositories;

use App\Models\SchoolType;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\SchoolTypeRepositoryInterface;

class SchoolTypeRepository implements SchoolTypeRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredSchoolTypes($request)
  {
    return  SchoolType::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllSchoolTypes()
  {
    return  SchoolType::isActive(true)
      ->get();
  }

  public function getSchoolTypeById($educationalSubjectId)
  {
    $educationalSubject = SchoolType::findOrFail($educationalSubjectId);
    return $educationalSubject;
  }

  public function getSchoolTypeRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createSchoolType($request)
  {
    $request_data = $this->getSchoolTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'educationalSubjects/', '', '');
    } //end of if

    $educationalSubject = SchoolType::create($request_data);

    return   $educationalSubject;
  }

  public function updateSchoolType($request, $educationalSubject)
  {
    $request_data = $this->getSchoolTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'educationalSubjects/', $educationalSubject->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $educationalSubject->update($request_data);

    return true;
  }

  public function deleteSchoolType($educationalSubject)
  {
    $this->removeImage($educationalSubject->image, 'educationalSubjects');
    $educationalSubject->delete();
    return true;
  }
}
