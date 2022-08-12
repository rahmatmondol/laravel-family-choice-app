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

class ReservationsController  extends Controller
{

  use ResponseTrait;
  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
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
    $reservation = $this->schoolRepository->addReservation($request);

    return $this->sendResponse(new ReservationResource($reservation), "");
  }

  public function update_reservation(ReservationFormRequest $request)
  {
    // dd($request->all());
    $reservation = $this->schoolRepository->updateReservation($request);

    return $this->sendResponse(new ReservationResource($reservation), "");
  }

  public function customer_reservations(Request $request)
  {
    $reservation = $this->schoolRepository->customerReservations();

    return $this->sendResponse(new ReservationCollection($reservation), "");
  }
}
