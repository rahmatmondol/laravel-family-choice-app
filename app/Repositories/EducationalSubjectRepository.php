<?php

namespace App\Repositories;

use App\Models\EducationalSubject;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\EducationalSubjectRepositoryInterface;

class EducationalSubjectRepository implements EducationalSubjectRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredEducationalSubjects($request)
  {
    return  EducationalSubject::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllEducationalSubjects()
  {
    return  EducationalSubject::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->get();
  }

  public function getEducationalSubjectById($educationalSubjectId)
  {
    $educationalSubject = EducationalSubject::findOrFail($educationalSubjectId);
    return $educationalSubject;
  }

  public function getEducationalSubjectRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createEducationalSubject($request)
  {
    $request_data = $this->getEducationalSubjectRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'educationalSubjects/', '', '');
    } //end of if

    $educationalSubject = EducationalSubject::create($request_data);

    return   $educationalSubject;
  }

  public function updateEducationalSubject($request, $educationalSubject)
  {
    $request_data = $this->getEducationalSubjectRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'educationalSubjects/', $educationalSubject->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $educationalSubject->update($request_data);

    return true;
  }

  public function deleteEducationalSubject($educationalSubject)
  {
    $this->removeImage($educationalSubject->image, 'educationalSubjects');
    $educationalSubject->delete();
    return true;
  }
}
