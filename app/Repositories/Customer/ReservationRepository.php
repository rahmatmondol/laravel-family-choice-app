<?php

namespace App\Repositories\Customer;

use App\Enums\ReservationStatus;
use App\Interfaces\Customer\ReservationRepositoryInterface;
use App\Models\Reservation;
use App\Models\SchoolGrade;
use App\Models\ChildAttachment;
use App\Models\Grade;
use App\Models\PaidService;
use App\Models\School;
use App\Models\SubscriptionType;
use App\Models\Transportation;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Model;

class ReservationRepository implements ReservationRepositoryInterface
{
  use UploadFileTrait;

  #addReservation
  public function addReservation($request)
  {
    $customer = getCustomer();
    $school = School::find($request->school_id);
    $isSchool = $school->is_school_type;
    $grade = Grade::find($request->input('child.grade_id'));
    $fees = $this->calculateFees($school, $grade);
    $reservation = Reservation::create([
      'parent_name'           => $request->parent_name,
      'parent_phone'          => $request->parent_phone,
      'parent_date_of_birth'  => $request->parent_date_of_birth,
      'address'               => $request->address,
      'identification_number' => $request->identification_number,
      'school_id'             => $request->school_id,
      'customer_id'           => $customer->id,
      'total_fees'            => $fees['totalFees'],
    ]);
    if ($child = $request->child) {
      $child = $reservation->child()->create([
        'child_name'              => $child['child_name'],
        'date_of_birth'           => $child['date_of_birth'],
        'gender'                  => $child['gender'],
        'grade_id'                => $isSchool ? $child['grade_id'] : null,
        'course_id'               => !$isSchool ? $child['course_id'] : null,
        'subscription_type_id'    => !$isSchool ? $child['subscription_type_id'] : null,
        'transportation_id'       => $request->input('child.transportation_id'),
        'total_fees'              => $fees['totalFees'],
        'subscription_type_price' => $fees['subscriptionTypeFees'] ?? null,
        'transportation_price'    => $fees['transportationPrice'] ?? null,
        // 'fees'                    => $schoolGrade->fees,
        // 'administrative_expenses' => $schoolGrade->administrative_expenses,
      ]);

      foreach ($request->child['attachments'] ?? [] as $key => $attachment) {
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
    $this->attachPaidServices($reservation);
    if ($school->is_nursery_type)
      $this->attachNurseryFees($reservation);
    if ($school->is_school_type)
      $this->attachGradeFees($reservation, $grade);
    return $reservation->load([
      'school.translations', 'child.grade.translations', 'child.course.translations', 'nurseryFees', 'gradeFees', 'paidServices', 'child.attachments.attachment.translation'
    ]);
  }

  #addReservation
  public function updateReservation($request)
  {
    $changes = 0;
    $reservation = Reservation::findOrFail($request->reservation_id);
    $school = $reservation->school;
    $isSchool = $school->is_school_type;
    $grade = Grade::find($request->input('child.grade_id'));
    $fees = $this->calculateFees($school, $grade);
    $reservation->fill([
      'parent_name'           => $request->parent_name,
      'parent_phone'          => $request->parent_phone,
      'parent_date_of_birth'  => $request->parent_date_of_birth,
      'address'               => $request->address,
      'identification_number' => $request->identification_number,
      'total_fees'            => $fees['totalFees'],
    ]);
    $changes += count($reservation->getDirty());
    $reservation->save();

    $child = $reservation->child;
    if ($request_child = $request->child) {
      $child->fill([
        'child_name'              => $request_child['child_name'],
        'date_of_birth'           => $request_child['date_of_birth'],
        'gender'                  => $request_child['gender'],
        'grade_id'                => $isSchool ? $child['grade_id'] : null,
        'course_id'               => !$isSchool ? $child['course_id'] : null,
        'subscription_type_id'    => !$isSchool ? $child['subscription_type_id'] : null,
        'transportation_id'       => $request->input('child.transportation_id'),
        'total_fees'              => $fees['totalFees'],
        'subscription_type_price' => $fees['subscriptionTypeFees'] ?? null,
        'transportation_price'    => $fees['transportationPrice'] ?? null,
      ]);
      $child->save();
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
    $this->attachPaidServices($reservation);
    if ($school->is_nursery_type)
      $this->attachNurseryFees($reservation);
    if ($school->is_school_type && isset($grade))
      $this->attachGradeFees($reservation, $grade);
    if ($changes != 0) {
      $reservation->update(['status' => ReservationStatus::Pending->value]);
      $this->logReservation($reservation);
    }
    return $reservation->load([
      'school.translations', 'child.grade.translations', 'child.course.translations', 'nurseryFees', 'gradeFees', 'paidServices', 'child.attachments.attachment.translation'
    ]);
  }

  public function calculateFees($school, $grade = null)
  {
    $request = request();
    $totalGradeFees = $totalNurseryFees = $subscriptionTypeFees = $totalPaidServicesFees = 0;
    if ($paidServices = request()->input('child.paid_services'))
      $totalPaidServicesFees = PaidService::find($paidServices)->sum('price');
    $transportationFees = $request->input('child.transportation_id') != null ? Transportation::find($request->input('child.transportation_id'))->price : 0;
    if ($school->is_school_type && isset($grade)) {
      $totalGradeFees = $grade->getActiveGradeFees($school->id)->sum('price');
    }
    if ($school->is_nursery_type) {
      $totalNurseryFees = $school->activeNurseryFees()->sum('price');
      $subscriptionTypeFees = $request->input('child.subscription_type_id') != null ? SubscriptionType::find($request->input('child.subscription_type_id'))->price : 0;
    }
    // dd($totalGradeFees ,$totalPaidServicesFees, $totalNurseryFees , $subscriptionTypeFees , $transportationFees);

    $totalFees = $totalPaidServicesFees + $transportationFees + $totalGradeFees + $totalNurseryFees + $subscriptionTypeFees;
    return [
      'totalFees'             => $totalFees,
      'subscriptionTypeFees'  => $subscriptionTypeFees,
      'transportationPrice'   => $transportationFees,
    ];
  }

  public function attachPaidServices($reservation)
  {
    $data  = [];
    $paidServices = PaidService::find(request()->input('child.paid_services'));
    foreach ($paidServices  as $service) {
      $data[$service->id] = ['price' => $service->price];
    }
    if ($data)
      $reservation->paidServices()->sync($data);
    else
      $reservation->paidServices()->sync([]);
  }

  public function attachNurseryFees($reservation)
  {
    $data  = [];
    $activeNurseryFees = $reservation->school?->activeNurseryFees()->get();
    foreach ($activeNurseryFees  as $nurseryFees) {
      $data[$nurseryFees->id] = ['price' => $nurseryFees->price];
    }
    if ($data)
      $reservation->nurseryFees()->sync($data);
    else
      $reservation->nurseryFees()->sync([]);
  }

  public function attachGradeFees($reservation, $grade)
  {
    $data  = [];
    $activeGradeFees = $grade->getActiveGradeFees($reservation->school_id);
    foreach ($activeGradeFees  as $gradeFees) {
      $data[$gradeFees->id] = ['price' => $gradeFees->price];
    }
    if ($data)
      $reservation->gradeFees()->sync($data);
    else
      $reservation->gradeFees()->sync([]);
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
      'school.type.translations',
      'school.translations',
      'child.grade.translations',
      'child.reservation.school.type',
      'child.reservation.gradeFees',
      'child.reservation.nurseryFees',
      'child.reservation.paidServices',
      'child.transportation.translations',
      'child.subscription_type.translations',
      'child.course.translations',
      'child.course.school',
      'child.course.subscription',
      // 'nurseryFees',
      // 'gradeFees',
      // 'paidServices',
      'child.attachments.attachment.translation'
    ])->latest()->paginate(request()->perPage ?? 20);
  }

  public function reservationDetails($reservationId)
  {
    dd(getCustomer()->reservations()->where(
      'id',$reservationId
    )->with([
      'school.translations', 'child.grade.translations', 'child.course.translations', 'nurseryFees', 'gradeFees', 'paidServices', 'child.attachments.attachment.translation'
    ])->first());
    return getCustomer()->reservations()->where(
      'id',$reservationId
    )->with([
      'school.translations', 'child.grade.translations', 'child.course.translations', 'nurseryFees', 'gradeFees', 'paidServices', 'child.attachments.attachment.translation'
    ])->first();
  }
}
