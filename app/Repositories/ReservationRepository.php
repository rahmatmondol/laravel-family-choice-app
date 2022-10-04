<?php

namespace App\Repositories;

use App\Scopes\OrderScope;
use App\Models\Reservation;
use App\Traits\UploadFileTrait;
use App\Services\NotificationService;
use App\Interfaces\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredReservations($request)
  {
    $reservations =  Reservation::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->whenCourse($request->course_id)
      ->whenCustomer($request->customer_id)
      ->whenPaymentStatus($request->payment_status)
      ->whenStatus($request->status)
      ->whenDateRange($request->date_range)
      ->latest()
      ->with(['school.translation', 'customer', 'course.translation'])
      ->paginate($request->perPage ?? 50);

    return $reservations;
  }

  public function getReservationById($reservationId)
  {
    return Reservation::with(['child.attachments.attachment.translations'])->findOrFail($reservationId);
  }

  public function updateReservation($request, $reservation)
  {
    $reservation->fill([
      'status' => $request->status,
      'reason_of_refuse' => $request->reason_of_refuse,
    ]);
    $changes = $reservation->getDirty();
    $reservation->save();

    if (count($changes) != 0) {

      $customer = $reservation->customer;

      $this->logReservation($reservation);

      $changes = $reservation->getChanges();
      if (isset($changes['status']) || isset($changes['reason_of_refuse'])) {
        NotificationService::sendReservationNotification($request->status, $reservation);
      }
    }

    return true;
  }

  public function logReservation($reservation)
  {
    $status  = [
      "pending" => 'في وضع المراجعة من الادارة',
      "accepted" => 'تم قبول الطلب',
      "rejected" => 'تم رفض الطلب بسبب',
    ];
    $description = $status[$reservation->status] ?? '';
    if ($reservation->status == 'rejected') {
      $description = " [$reservation->reason_of_refuse] " . $description;
    }
    activity('reservation')
      ->on($reservation)
      ->withProperties(['causer_name' => request()->is('admin/*') ? getAdmin()?->full_name : getAuthSchool()?->title])
      ->log($description);
  }

  public function deleteReservation($reservation)
  {
    $reservation->delete();
    return true;
  }
}
