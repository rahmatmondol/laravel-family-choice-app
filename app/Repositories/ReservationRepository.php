<?php

namespace App\Repositories;

use App\Scopes\OrderScope;
use App\Models\Reservation;
use App\Traits\UploadFileTrait;
use Spatie\Activitylog\LogOptions;
use App\Services\NotificationService;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Interfaces\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface
{
  use UploadFileTrait;
  use LogsActivity;

  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults();
  }
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

    $this->logReservation($reservation,description:'custom description');

    NotificationService::sendReservationNotification($request->status, $customer, $reservation);

    return true;
  }

  public function logReservation($reservation,$description=''){
    activity('reservation')
    ->on($reservation)
    ->logOnly(['*'])->logOnlyDirty()
    // ->performedOn($reservation)
    // ->causedBy($customer)
    // ->withProperties(['customProperty' => 'customValue'])
    ->log($description);

  }

  public function deleteReservation($reservation)
  {
    $reservation->delete();
    return true;
  }
}
