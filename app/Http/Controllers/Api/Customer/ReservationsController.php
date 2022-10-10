<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;
use App\Http\Resources\ReservationResource;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\AttachmentRepositoryInterface;
use App\Http\Requests\Api\ReservationFormRequest;
use App\Http\Resources\Collection\ReservationCollection;
use App\Http\Requests\Api\GetSchoolAttachmentFormRequest;
use App\Http\Requests\Api\ReservationDetailsFormRequest;
use App\Interfaces\Customer\ReservationRepositoryInterface;
use App\Models\Reservation;

class ReservationsController  extends Controller
{

  use ResponseTrait;
  public function __construct(
    private ReservationRepositoryInterface $reservationRepository,
    private AttachmentRepositoryInterface $attachmentRepository,
  ) {
  } // end of constructor

  public function school_attachments(GetSchoolAttachmentFormRequest $request)
  {
    $attachments = $this->attachmentRepository->getAttachments($request);

    return $this->sendResponse(AttachmentResource::collection($attachments), "");
  }

  public function add_reservation(ReservationFormRequest $request)
  {
    $reservation = $this->reservationRepository->addReservation($request);

    return $this->sendResponse(new ReservationResource($reservation), "");
  }

  public function update_reservation(ReservationFormRequest $request)
  {
    $reservation = $this->reservationRepository->updateReservation($request);

    return $this->sendResponse(new ReservationResource($reservation), "");
  }

  public function customer_reservations(Request $request)
  {
    $reservation = $this->reservationRepository->customerReservations();

    return $this->sendResponse(new ReservationCollection($reservation), "");
  }

  public function reservation_details(ReservationDetailsFormRequest $request)
  {
    $reservation = $this->reservationRepository->reservationDetails($request->reservation_id);

    return $this->sendResponse(new ReservationResource($reservation), "");
  }
}
