<?php

namespace App\Repositories;

use App\Models\Course;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CourseRepository implements CourseRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredCourses($request)
  {
    return  Course::withoutGlobalScope(new OrderScope)
      ->withTranslation(app()->getLocale())
      ->with(['school.translations','subscription.translations'])
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getCourses($request)
  {
    return  Course::withTranslation(app()->getLocale())
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->WhenSubscription($request->subscription_id)
      ->isActive(true)
      ->with(['subscription.translation'])
      ->withTranslation(app()->getLocale())
      ->paginate(request()->perPage ?? 20);
  }

  public function getCourseById($course)
  {
    $course = Course::findOrFail($course);
    return $course;
  }

  public function getCourseRequestData($request)
  {
    $request_data = array_merge(['status', 'school_id','subscription_id', 'type', 'from_date', 'to_date', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createCourse($request)
  {
    $request_data = $this->getCourseRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'courses/', '', '');
    } //end of if

    $course = Course::create($request_data);

    return   $course;
  }

  public function updateCourse($request, $course)
  {
    $request_data = $this->getCourseRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'courses/', $course->image);
    } //end of if

    $course->update($request_data);

    return true;
  }

  public function deleteCourse($course)
  {
    $this->removeImage($course->image, 'courses');
    $course->delete();
    return true;
  }
}
