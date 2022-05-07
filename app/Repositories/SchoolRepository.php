<?php

namespace App\Repositories;

use App\Models\Child;
use App\Models\School;
use App\Scopes\OrderScope;
use App\Models\Reservation;
use App\Models\SchoolGrade;
use App\Models\SchoolImage;
use App\Models\ChildAttachment;
use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\SchoolRepositoryInterface;

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
      ->whenSearch()
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getSchools($request)
  {

    DB::enableQueryLog();
    $schools =  School::whenSearch()
      ->isActive(true)
      ->whenFromPrice()
      ->whenToPrice()
      ->whenSortByName()
      ->whenSortByPrice()
      ->whenSortByReview()
      ->whenLocation()
      ->whenGrades()
      ->whenSchoolTypes()
      ->whenEducationTypes()
      ->whenEducationalSubjects()
      ->withTranslation()
      ->with(['educationalSubjects', 'educationTypes', 'schoolTypes', 'grades'])
      ->paginate($request->perPage ?? 20);

    return $schools;
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

    if ($request->cover) {
      $request_data['cover'] = $this->uploadImages($request->cover, 'schools/', '', '');
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

    if ($request->cover) {
      $request_data['cover'] = $this->uploadImages($request->cover, 'schools/', $school->cover);
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

  #addReservation
  public function addReservation($request)
  {
    $customer = getCustomer();
    $totalFees = 0;

    $reservation = Reservation::create([
      'parent_name'           => $request->parent_name,
      'address'               => $request->address,
      'identification_number' => $request->identification_number,
      'school_id'             => $request->school_id,
      'customer_id'           => $customer->id,
    ]);

    foreach ($request->children as $item) {

      $schoolGrade = SchoolGrade::where([[
        'school_id', $request->school_id
      ], [
        'grade_id',   $item['grade_id']
      ]])->first();

      $subFees = $schoolGrade->fees + $schoolGrade->administrative_expenses;
      $totalFees += $subFees;

      $child = Child::create([
        'child_name'              => $item['child_name'],
        'date_of_birth'           => $item['date_of_birth'],
        'gender'                  => $item['gender'],
        'grade_id'                => $item['grade_id'],
        'reservation_id'          => $reservation->id,
        'fees'                    => $schoolGrade->fees,
        'administrative_expenses' => $schoolGrade->administrative_expenses,
        // 'total_fees'            => $subFees,
      ]);

      foreach ($item['attachments'] as $key => $attachment) {
        $file_path = $this->uploadFile($attachment, 'attachment_reservation/', '');

        if ($file_path) {
          ChildAttachment::create([
            'attachment_id' => (int)$key,
            'child_id'      => $child->id,
            'attachment'    => $file_path,
          ]);
        }
        // dd('done');
      } // end $child['attachments']
    } // end $request->children

    $reservation->update([
      'total_fees' => $totalFees,
    ]);

    return $reservation;
  }

  #addReservation
  public function updateReservation($request)
  {
    $reservation = Reservation::findOrFail($request->reservation_id);
    $reservation->update([
      'parent_name'           => $request->parent_name,
      'address'               => $request->address,
      'identification_number' => $request->identification_number,
    ]);

    foreach ($request->children as $item) {

      $child = Child::find($item['child_id']);

      $child->update([
        'child_name'            => $item['child_name'],
        'date_of_birth'         => $item['date_of_birth'],
        'gender'                => $item['gender'],
        'reservation_id'        => $reservation->id,
      ]);

      foreach ($item['attachments'] as $key => $attachment) {

        $file_path = $this->uploadFile($attachment, 'attachment_reservation/', '');

        if ($file_path) {
          ChildAttachment::updateOrCreate([
            'attachment_id' => (int)$key,
            'child_id'      => $item['child_id']
          ], [
            'attachment'    => $file_path,
          ]);
        }
        // dd('done');
      } // end $child['attachments']
    } // end $request->children

    return $reservation;
  }

  #customerReservations
  public function customerReservations()
  {
    return getCustomer()->reservations()->with(['children.attachments'])->latest()->paginate(request()->perPage ?? 20);
  }

  #customerReservations
  public function schoolReviews($school)
  {
    // dd($school->reviews()->latest()->get());
    return $school->reviews()->latest()->paginate(request()->perPage ?? 20);
  }
}
