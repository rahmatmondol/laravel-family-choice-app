<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Requests\Api\AddReservationRequest;
use App\Models\Child;
use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\StudentDocument;
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
  use UploadFileTrait;
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

    public function store_reservation(Request $request)
    {
        // Perform manual validation
        $validator = Validator::make($request->all(), [
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:255',
            'parent_date_of_birth' => 'nullable|date_format:Y-m-d',
            'address' => 'required|string|max:255',
            'document_id' => 'required|integer',
            'school_id' => 'required|integer',
            'child_name' => 'required|string|max:255',
            'child_photo' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'child_birth_certificate' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'child_health_card' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'child_date_of_birth' => 'required|date|date_format:Y-m-d',
            'child_gender' => 'required|in:male,female',
            'status' => 'string|in:pending,accepted,rejected',
            'payment_status' => 'string|in:pending,succeeded,failed',
            'identification_number' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->all(), 422);
        }

        // If validation passes, proceed with reservation creation
        try {
            $user_id = auth()->user()->id;

            // Create a new reservation instance and fill it with validated request data
            $reservation = new Reservation();
            $reservation->parent_name = $request->parent_name;
            $reservation->parent_phone = $request->parent_phone;
            $reservation->parent_date_of_birth = $request->parent_date_of_birth;
            $reservation->address = $request->address;
            $reservation->identification_number = $request->identification_number;
            $reservation->school_id = $request->school_id;
            $reservation->document_id = $request->document_id;
            $reservation->customer_id = $user_id;
            // Save the reservation
            $reservation->save();

            // Create a new child instance and fill it with validated request data
            $childData = new Child();
            $childData->child_name = $request->child_name;
            $childData->date_of_birth = $request->child_date_of_birth;
            $childData->gender = $request->child_gender;
            $childData->save();

            // Create a new student document instance and fill it with validated request data
            $document = new StudentDocument();
            $document->child_id = $childData->id;
            if ($request->hasFile('child_photo')) {
                $photo = $this->uploadFile($request->file('child_photo'), 'document', ''); // Pass an empty string for the third argument
                $document->photo = $photo; // Store the child photo path in the database
            }
            if ($request->hasFile('child_birth_certificate')) {
                $birth_certificate = $this->uploadFile($request->file('child_birth_certificate'), 'document', ''); // Pass an empty string for the third argument
                $document->birth_certificate = $birth_certificate; // Store the child birth certificate path in the database
            }
            if ($request->hasFile('child_health_card')) {
                $health_card = $this->uploadFile($request->file('child_health_card'), 'document', ''); // Pass an empty string for the third argument
                $document->health_card = $health_card; // Store the child health card path in the database
            }

            // Return success response with the newly created reservation
            return $this->sendResponse("Reservation added successfully");
        } catch (\Exception $e) {
            // If an error occurs, return an error response
            return $this->sendError("Failed to add reservation", [], 500);
        }
    }

//    public function store_reservation(AddReservationRequest $request)
//    {
//        // Validate the incoming request data
//        try {
//            $user_id = auth()->user()->id;
//            // Create a new reservation instance and fill it with validated request data
//            $reservation = new Reservation();
//            $reservation->parent_name = $request->parent_name;
//            $reservation->parent_phone = $request->paraent_phone;
//            $reservation->parent_date_of_birth = $request->parent_date_of_birth;
//            $reservation->address = $request->address;
//            $reservation->identification_number = $request->identification_number;
//            $reservation->school_id = $request->school_id;
//            $reservation->document_id = $request->document_id;
//            $reservation->customer_id = $user_id;
//            // Save the reservation
//            $reservation->save();
//
//            $childData = new Child();
//            $childData->child_name = $request->Chideren_name;
//            $childData->date_of_birth = $request->child_date_of_birth;
//
//            $childData->gender = $request->gernder;
//            $childData->save();
//
//            $document = new StudentDocument();
//            $document->child_id = $childData->id;
//            if ($request->hasFile('Children_photo')) {
//                $photo = $this->uploadFile($request->file('back_side'), 'document', ''); // Pass an empty string for the third argument
//                $document->photo = $photo; // Store the back side image path in the database
//            }
//            if ($request->hasFile('Children_birth_certificate')) {
//                $birth_certificate = $this->uploadFile($request->file('back_side'), 'document', ''); // Pass an empty string for the third argument
//                $document->birth_certificate = $birth_certificate; // Store the back side image path in the database
//            }
//            if ($request->hasFile('Children_health_card')) {
//                $health_card = $this->uploadFile($request->file('back_side'), 'document', ''); // Pass an empty string for the third argument
//                $document->health_card = $health_card; // Store the back side image path in the database
//            }
//
//            // Return success response with the newly created reservation
//            return $this->sendResponse( "Reservation added successfully");
//        } catch (\Exception $e) {
//            // If an error occurs, return an error response
////            return $this->sendError("Failed to add reservation", [], 500);
//        }
//    }

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
