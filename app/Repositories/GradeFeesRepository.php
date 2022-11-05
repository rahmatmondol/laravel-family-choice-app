<?php

namespace App\Repositories;

use App\Models\GradeFees;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\GradeFeesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class GradeFeesRepository implements GradeFeesRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredGradeFees($request)
  {
    return  GradeFees::withoutGlobalScope(new OrderScope)
      ->withTranslation(app()->getLocale())
      ->with(['school.translations','grade.translations'])
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->whenGrade($request->grade_id)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getGradeFees($request)
  {
    return  GradeFees::withTranslation(app()->getLocale())
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->WhenSubscription($request->subscription_id)
      ->isActive(true)
      ->with(['school.translations','grade.translations'])
      ->withTranslation(app()->getLocale())
      ->paginate(request()->perPage ?? 20);
  }

  public function getGradeFeesById($gradeFees)
  {
    $gradeFees = GradeFees::findOrFail($gradeFees);
    return $gradeFees;
  }

  public function getGradeFeesRequestData($request)
  {
    $request_data = array_merge(['status', 'school_id', 'grade_id','price', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createGradeFees($request)
  {
    $request_data = $this->getGradeFeesRequestData($request);

    $gradeFees = GradeFees::create($request_data);

    return   $gradeFees;
  }

  public function updateGradeFees($request, $gradeFees)
  {
    $request_data = $this->getGradeFeesRequestData($request);

    $gradeFees->update($request_data);

    return true;
  }

  public function deleteGradeFees($gradeFees)
  {
    $gradeFees->delete();
    return true;
  }
}
