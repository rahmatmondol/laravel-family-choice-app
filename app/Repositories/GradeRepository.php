<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\GradeRepositoryInterface;

class GradeRepository implements GradeRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredGrades($request)
  {
    return  Grade::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllGrades()
  {
    return  Grade::isActive(true)->withTranslation(app()->getLocale())
      // ->withoutGlobalScope(new OrderScope)
      ->get();
  }

  public function getGradeById($gradeId)
  {
    $grade = Grade::withTranslation(app()->getLocale())
      ->findOrFail($gradeId);
    return $grade;
  }

  public function getGradeRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createGrade($request)
  {
    $request_data = $this->getGradeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'grades/', '', '');
    } //end of if

    $grade = Grade::create($request_data);

    return   $grade;
  }

  public function updateGrade($request, $grade)
  {
    $request_data = $this->getGradeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'grades/', $grade->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $grade->update($request_data);

    return true;
  }

  public function deleteGrade($grade)
  {
    $this->removeImage($grade->image, 'grades');
    $grade->delete();
    return true;
  }
}
