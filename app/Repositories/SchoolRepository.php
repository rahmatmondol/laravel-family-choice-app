<?php

namespace App\Repositories;

use App\Enums\ReservationStatus;
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
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\SchoolRepositoryInterface;
use App\Services\NotificationService;

class SchoolRepository implements SchoolRepositoryInterface
{
  use UploadFileTrait;

  public function getAllSchools()
  {
    return School::isActive(true)->withTranslation(app()->getLocale())->get();

    // return School::isActive(true)->listsTranslations('title')->get();
  }

  public function getFilteredSchools($request)
  {
    return  School::withoutGlobalScope(new OrderScope)
      ->withTranslation(app()->getLocale())
      // ->with(['educationalSubjects','educationTypes','schoolTypes','services','grades','types','schoolImages'])
      ->whenSearch()
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getSchools($request)
  {

    // DB::enableQueryLog();
    $schools =  School::whenSearch()
      ->isActive(true)
      ->whenFromPrice()
      ->whenToPrice()
      ->whenSortByName()
      ->whenSortByPrice()
      ->whenSortByReview()
      ->whenLocation()
      ->WhenTypes()
      ->whenGrades()
      ->whenSchoolTypes()
      ->whenEducationTypes()
      ->whenEducationalSubjects()
      ->withTranslation()
      ->with(['educationalSubjects', 'educationTypes', 'schoolTypes', 'types', 'grades', 'services', 'schoolImages'])
      ->paginate($request->perPage ?? 20);

    return $schools;
  }

  public function getSchoolById($schoolId)
  {
    if ($schoolId instanceof Model) {
      $school = $schoolId;
    } else {
      $school = School::findOrFail($schoolId);
    }
    return $school->load(['educationalSubjects', 'educationTypes', 'schoolTypes', 'grades','services','schoolImages']);
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

    if ($request->services) {
      $services = array_filter((array)$request->services, function ($value) {
        return !is_null($value);
      });

      $school->services()->attach($services);
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

    $services = array_filter((array)$request->services, function ($value) {
      return !is_null($value);
    });

    $school->educationalSubjects()->sync($educationalSubjects);
    $school->educationTypes()->sync($educationTypes);
    $school->schoolTypes()->sync($schoolTypes);
    $school->types()->sync($types);
    $school->services()->sync($services);

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
    $attachments = $school->attachments()->get();
    $this->deleteAttachments($attachments, 'school_images');
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
      'parent_phone'          => $request->parent_phone,
      'parent_date_of_birth'  => $request->parent_date_of_birth,
      'address'               => $request->address,
      'identification_number' => $request->identification_number,
      'school_id'             => $request->school_id,
      'course_id'             => $request->course_id,
      'customer_id'           => $customer->id,
    ]);

    if ($child = $request->child) {

      $schoolGrade = SchoolGrade::where([[
        'school_id', $request->school_id
      ], [
        'grade_id',   $child['grade_id']
      ]])->first();

      $totalFees = $schoolGrade->fees + $schoolGrade->administrative_expenses;

      $child = $reservation->child()->create([
        'child_name'              => $child['child_name'],
        'date_of_birth'           => $child['date_of_birth'],
        'gender'                  => $child['gender'],
        'grade_id'                => $child['grade_id'],
        'reservation_id'          => $reservation->id,
        'fees'                    => $schoolGrade->fees,
        'administrative_expenses' => $schoolGrade->administrative_expenses,
      ]);

      foreach ($request->child['attachments'] as $key => $attachment) {
        $file_name = $this->uploadFile($attachment, 'child_attachments/', '');

        if ($file_name) {
          ChildAttachment::create([
            'attachment_id' => (int)$key,
            'child_id'      => $child->id,
            'attachment_file'    => $file_name,
          ]);
        }
      } // end $child['attachments']


    } // end $request->children

    return $reservation->load([
      'school', 'course', 'grade', 'child.grade', 'child.attachments.attachment.translation'
    ]);
  }

  #addReservation
  public function updateReservation($request)
  {
    $changes = 0;
    $reservation = Reservation::findOrFail($request->reservation_id);
    $reservation->fill([
      'parent_name'           => $request->parent_name,
      'parent_phone'          => $request->parent_phone,
      'parent_date_of_birth'  => $request->parent_date_of_birth,
      'address'               => $request->address,
      'identification_number' => $request->identification_number,
    ]);
    $changes += count($reservation->getDirty());
    $reservation->save();

    $child = $reservation->child;
    // if ($request->child) {
    //   $child->fill([
    //     'child_name'            => $child['child_name'],
    //     'date_of_birth'         => $child['date_of_birth'],
    //     'gender'                => $child['gender'],
    //   ]);
    //   $changes += count($reservation->getDirty());
    //   $reservation->save();
    // }

    if ($request_child = $request->child) {

      $child->fill([
        'child_name'            => $request_child['child_name'],
        'date_of_birth'         => $request_child['date_of_birth'],
        'gender'                => $request_child['gender'],
      ]);

      $changes += count($reservation->getDirty());
      $reservation->save();

      if (isset($request->child['attachments'])) {
        foreach ($request_child['attachments'] as $id => $attachment) {
          $child_attachment =  ChildAttachment::where([[
            'attachment_id', $id
          ], [
            'child_id', $child->id
          ]])->first();

          $file_name = $this->uploadFile($attachment, 'child_attachments/', $child_attachment->attachment_file);

          if ($file_name) {
            $child_attachment = $child_attachment->fill([
              'attachment_file'    => $file_name,
            ]);

            $changes += count($child_attachment->getDirty());
            $child_attachment->save();
          }
        } // end $child['attachments']
      }
    } // end $request->children

    // dd($changes);
    if ($changes != 0) {
      $reservation->update(['status' => ReservationStatus::Pending->value]);
      $customer = $reservation->customer;

      $this->logReservation($reservation);
      // NotificationService::sendReservationNotification($request->status, $customer, $reservation);
    }

    return $reservation->load([
      'school', 'course', 'grade', 'child.grade', 'child.attachments.attachment.translation'
    ]);
  }

  public function logReservation($reservation)
  {
    activity('reservation')
      ->on($reservation)
      ->withProperties(['causer_name' => getCustomer()->full_name])
      ->log(" تم تعديل بيانات الحجز  وتحويلة الي  وضع المراجعة من الادارة");
  }

  public function customerReservations()
  {
    return getCustomer()->reservations()->with([
      'school', 'course', 'grade', 'child.grade', 'child.attachments.attachment.translation'
    ])->latest()->paginate(request()->perPage ?? 20);
  }

  public function schoolReviews($school)
  {
    return $school->reviews()->with(['customer', 'school',])->latest()->paginate(request()->perPage ?? 20);
  }
}
