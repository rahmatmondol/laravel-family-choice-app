<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\ReservationRepositoryInterface;
use App\Services\NotificationService;

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
      ->latest()
      ->with(['school', 'customer','course'])
      ->paginate($request->perPage ?? 50);

    return $reservations;
  }

  public function getReservationById($reservationId)
  {
    return Reservation::findOrFail($reservationId);
  }

  public function updateReservation($request, $reservation)
  {
    $reservation->update([
      'status' => $request->status,
      'reason_of_refuse' => $request->reason_of_refuse,
    ]);

    $customer = $reservation->customer;

    NotificationService::sendReservationNotification($request->status, $customer, $reservation);

    return true;
  }

  public function deleteReservation($reservation)
  {
    $reservation->delete();
    return true;
  }
}
