<?php

namespace App\Repositories;

use App\Models\School;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\SchoolRepositoryInterface;
use App\Models\SchoolImage;

class SchoolRepository implements SchoolRepositoryInterface
{
  use UploadFileTrait;

  public function getAllSchools()
  {
    return School::isActive(true)->get();
  }

  public function getFilteredSchools($request)
  {
    return  School::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getSchools($request)
  {
    $schools =  School::whenSearch($request->search)
      ->isActive(true)
      ->whenFromPrice()
      ->whenToPrice()
      ->WhenSortByName()
      ->whenLocation()
      ->latest()
      ->paginate($request->perPage ?? 20);

    $sorting = $this->getSorting();

    return $schools->setCollection($schools->sortBy($sorting['column'], 0, $sorting['type']));
  }

  public function getSorting()
  {
    $column = '';
    $type = '';

    if (request()->sortType != null) {
      $req = request()->sortType;
      if ($req == 'priceHL') {
        $column = 'fees';
        $type = true;
      }
      if ($req == 'priceLH') {
        $column = 'fees';
        $type = false;
      }
      if ($req == 'mostReview') {
        $column = 'review';
        $type = true;
      }
    }
    return ['column' => $column, 'type' => $type];
  }

  public function getSchoolById($schoolId)
  {
    $school = School::findOrFail($schoolId);
    return $school;
  }

  public function getSchoolRequestData($request)
  {
    $request_data = array_merge([
      'status', 'order_column', 'type', 'phone', 'whatsapp', 'email', 'available_seats', 'fees', 'lat', 'lng'
    ], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createSchool($request)
  {
    $request_data = $this->getSchoolRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'schools/', '', '');
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }

    $school = School::create($request_data);

    if ($request->educationalSubjects) {
      $educationalSubjects = array_filter((array)$request->educationalSubjects, function ($value) {
        return !is_null($value);
      });

      $school->educationalSubjects()->attach($educationalSubjects);
    } // end of if

    if ($request->educationTypes) {
      $educationTypes = array_filter((array)$request->educationTypes, function ($value) {
        return !is_null($value);
      });

      $school->educationTypes()->attach($educationTypes);
    } // end of if

    if ($request->schoolTypes) {
      $schoolTypes = array_filter((array)$request->schoolTypes, function ($value) {
        return !is_null($value);
      });

      $school->schoolTypes()->attach($schoolTypes);
    } // end of if

    if ($request->types) {
      $types = array_filter((array)$request->types, function ($value) {
        return !is_null($value);
      });

      $school->types()->attach($types);
    } // end of if

    if ($request->attachments) {
      $this->insertImages($request->attachments, $school->id);
    }
    return   $school;
  }

  public function updateSchool($request, $school)
  {
    $request_data = $this->getSchoolRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'schools/', $school->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }

    $school->update($request_data);


    $educationalSubjects = array_filter((array)$request->educationalSubjects, function ($value) {
      return !is_null($value);
    });

    $educationTypes = array_filter((array)$request->educationTypes, function ($value) {
      return !is_null($value);
    });

    $schoolTypes = array_filter((array)$request->schoolTypes, function ($value) {
      return !is_null($value);
    });

    $types = array_filter((array)$request->types, function ($value) {
      return !is_null($value);
    });

    $school->educationalSubjects()->sync($educationalSubjects);
    $school->educationTypes()->sync($educationTypes);
    $school->schoolTypes()->sync($schoolTypes);
    $school->schoolTypes()->sync($types);

    if ($request->attachments) {
      $this->insertImages($request->attachments, $school->id);
    } // end of if

    return true;
  }

  function insertImages($attachments, $school_id)
  {
    $attachments = $this->MultipleUploadImages($attachments, 'school_images/');

    foreach ($attachments as $file_name) {
      SchoolImage::create([
        'school_id' => $school_id,
        'image' => $file_name,
      ]);
    }
  }

  public function deleteSchool($school)
  {
    $this->removeImage($school->image, 'schools');
    $this->deleteAttachments('school_images', 'school_images', 'school_id', $school->id);
    $school->delete();
    return true;
  }

  public function deleteAttachment($id)
  {
    $this->deleteOneAttachment('school_images', 'school_images', $id);

    session()->flash('success', __('site.deleted_successfully'));
    return redirect()->back();
  }
}
