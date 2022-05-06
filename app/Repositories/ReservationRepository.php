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
    $reservation = Reservation::findOrFail($reservationId);
    return $reservation;
  }

  public function getReservationRequestData($request)
  {
    $request_data = array_merge([
      'status', 'order_column', 'type', 'phone', 'whatsapp', 'email', 'available_seats', 'fees', 'lat', 'lng'
    ], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function updateReservation($request, $reservation)
  {
    $request_data = $this->getReservationRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'reservations/', $reservation->image);
    } //end of if

    if ($request->cover) {
      $request_data['cover'] = $this->uploadImages($request->cover, 'reservations/', $reservation->cover);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }

    $reservation->update($request_data);


    $educationalSubjects = array_filter((array)$request->educationalSubjects, function ($value) {
      return !is_null($value);
    });

    $educationTypes = array_filter((array)$request->educationTypes, function ($value) {
      return !is_null($value);
    });

    $reservationTypes = array_filter((array)$request->reservationTypes, function ($value) {
      return !is_null($value);
    });

    $types = array_filter((array)$request->types, function ($value) {
      return !is_null($value);
    });

    $reservation->educationalSubjects()->sync($educationalSubjects);
    $reservation->educationTypes()->sync($educationTypes);
    $reservation->reservationTypes()->sync($reservationTypes);
    $reservation->reservationTypes()->sync($types);
    return true;
  }

  public function deleteReservation($reservation)
  {
    $reservation->delete();
    return true;
  }
}
