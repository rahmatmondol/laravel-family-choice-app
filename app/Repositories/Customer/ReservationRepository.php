<?php

namespace App\Repositories\Customer;

use App\Enums\ReservationStatus;
use App\Interfaces\Customer\ReservationRepositoryInterface;
use App\Models\Reservation;
use App\Models\SchoolGrade;
use App\Models\ChildAttachment;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Model;

class ReservationRepository implements ReservationRepositoryInterface
{
  use UploadFileTrait;

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

  public function reservationDetails($reservationId)
  {
    return getCustomer()->reservations()->where('id',$reservationId)->with([
      'school', 'course', 'grade', 'child.grade', 'child.attachments.attachment.translation'
    ])->first();
  }
}
