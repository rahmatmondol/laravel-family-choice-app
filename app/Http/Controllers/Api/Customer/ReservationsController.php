<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddReservationFormRequest;
use App\Http\Resources\AttachmentResource;
use App\Http\Resources\ReservationResource;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\AttachmentRepositoryInterface;
use App\Http\Resources\Collection\ReservationCollection;
use App\Http\Requests\Api\GetSchoolAttachmentFormRequest;
use App\Http\Requests\Api\ReservationDetailsFormRequest;
use App\Http\Requests\Api\UpdateReservationFormRequest;
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
    public function add(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:255',
            'parent_date_of_birth' => 'nullable|date_format:Y-m-d',
            'address' => 'required|string|max:255',
            'total_fees' => 'nullable|numeric',
            'reason_of_refuse' => 'nullable|string',
            'partial_payment_info' => 'nullable|array',
            'remaining_payment_info' => 'nullable|array',
            'refund_partial_payment_info' => 'nullable|array',
            'status' => 'string|in:pending,accepted,rejected',
            'payment_status' => 'string|in:pending,succeeded,failed',
            'identification_number' => 'required|string|max:255',
            'document_id' => 'required|integer', // Assuming document_id is required and should be an integer
        ]);

        try {
            // Create a new reservation instance and fill it with validated request data
            $reservation = new Reservation();
            $reservation->fill($validatedData);

            // Save the reservation
            $reservation->save();

            // Return success response with the newly created reservation
            return $this->sendResponse(new ReservationResource($reservation), "Reservation added successfully");
        } catch (\Exception $e) {
            // If an error occurs, return an error response
            return $this->sendError("Failed to add reservation", [], 500);
        }
    }

  public function add_reservation(AddReservationFormRequest $request)
  {

    $reservation = $this->reservationRepository->addReservation($request);
    $reservation->document_id = $request->document_id;
    $reservation->seve();

    return $this->sendResponse(new ReservationResource($reservation->refresh()), "");
  }

  public function update_reservation(UpdateReservationFormRequest $request)
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
