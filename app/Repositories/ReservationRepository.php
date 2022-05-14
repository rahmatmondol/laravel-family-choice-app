<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredReservations($request)
  {
    $reservations =  Reservation::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->whenSchool()
      ->whenPaymentStatus($request->payment_status)
      ->whenStatus($request->status)
      ->latest()
      ->with(['school', 'customer'])
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

    $messages = [
      'pending' => __('site.Your reservatin number is pending', ['reservation_number' => $reservation->id]),
      'accepted' => __('site.Your reservatin number is accepted', ['reservation_number' => $reservation->id]),
      'rejected' => __('site.Your reservatin number is rejected', ['reservation_number' => $reservation->id]),
    ];


    return true;
  }

  public function deleteReservation($reservation)
  {
    $reservation->delete();
    return true;
  }
}
