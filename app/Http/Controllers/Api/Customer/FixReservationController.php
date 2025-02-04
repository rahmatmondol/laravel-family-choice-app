<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddReservationRequest;
use App\Models\Child;
use App\Models\Grade;
use App\Models\PaidService;
use App\Models\Reservation;
use App\Models\School;
use App\Models\StudentDocument;
use App\Models\SubscriptionType;
use App\Models\Transportation;
use App\Traits\ResponseTrait;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Discount;

class FixReservationController extends Controller
{
    use ResponseTrait;
    use UploadFileTrait;

    //
    public function add(AddReservationRequest $request)
    {

        // If validation passes, proceed with reservation creation
        try {

            $customer = getCustomer();
            $school = School::find($request->schoolId);
            $isSchool = $school->is_school_type;
            $grade = Grade::find($request->input('child.grade_id'));
            $fees = $this->calculateFees($school, $grade);
            $user_id = auth()->user()->id;

            // Retrieve the discount applicable for the given school and grade
            $discount = Discount::where('school_id', $request->schoolId)
                ->where('status', 'active')
                ->where(function ($query) {
                    $now = now();
                    $query->where('starting_date', '<=', $now)
                        ->where('ending_date', '>=', $now)
                        ->orWhereNull('starting_date')
                        ->orWhereNull('ending_date');
                })
                ->first();

            // Calculate the discounted fees based on the discount type
            if ($discount) {
                if ($discount->discount_type === 'percentage') {
                    $discountedAmount = ($discount->percentage_discount / 100) * $fees['totalFees'];
                } else {
                    $discountedAmount = min($discount->discount_amount, $fees['totalFees']);
                }
                $fees['totalFees'] -= $discountedAmount;
            }

            // Create a new reservation instance and fill it with validated request data
            $reservation = new Reservation();
            $reservation->parent_name = $request->parent_Name;
            $reservation->parent_phone = $request->parent_Phone;
            $reservation->parent_date_of_birth = $request->parent_Date_of_birth;
            $reservation->address = $request->parent_Address;
            $reservation->identification_number = $request->identification_Number;
            $reservation->school_id = $request->schoolId;
            $reservation->document_id = $request->documentId;
            $reservation->customer_id = $user_id;
            $reservation->total_fees = $fees['totalFees'];
            // Save the reservation
            $reservation->save();

            // Create a new child instance and fill it with validated request data
            $childData = new Child();
            $childData->child_name = $request->child_name;
            $childData->date_of_birth = $request->child_date_of_birth;
            $childData->gender = $request->child_gender;
            $childData->reservation_id = $reservation->id;
            $childData->grade_id                = $isSchool ? $request->grade_id : null;
            $childData->course_id               = !$isSchool ? $request->course_id : null;
            $childData->subscription_type_id    = !$isSchool ? $request->subscription_type_id : null;
            $childData->total_fees = $fees['totalFees'];
            $childData->subscription_type_price = $fees['subscriptionTypeFees'] ?? null;
            $childData->transportation_price    = $fees['transportationPrice'] ?? null;
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
            return $this->sendResponse('', "Reservation added successfully");
        } catch (\Exception $e) {
            // If an error occurs, return an error response
            return $this->sendError("Failed to add reservation", ['error' => $e->getMessage()], 500);
        }
    }

    public function calculateFees($school, $grade = null)
    {
        $request = request();
        $totalGradeFees = $totalNurseryFees = $subscriptionTypeFees = $totalPaidServicesFees = 0;
        if ($paidServices = request()->input('child.paid_services'))
            $totalPaidServicesFees = PaidService::find($paidServices)->sum('price');
        $transportationFees = $request->input('child.transportation_id') != null ? Transportation::find($request->input('child.transportation_id'))->price : 0;
        if ($school->is_school_type && isset($grade)) {
            $totalGradeFees = $grade->getActiveGradeFees($school->id)->sum('price');
        }
        if ($school->is_nursery_type) {
            $totalNurseryFees = $school->activeNurseryFees()->sum('price');
            $subscriptionTypeFees = $request->input('child.subscription_type_id') != null ? SubscriptionType::find($request->input('child.subscription_type_id'))->price : 0;
        }

        $totalFees = $totalPaidServicesFees + $transportationFees + $totalGradeFees + $totalNurseryFees + $subscriptionTypeFees;
        return [
            'totalFees'             => $totalFees,
            'subscriptionTypeFees'  => $subscriptionTypeFees,
            'transportationPrice'   => $transportationFees,
        ];
    }

    public function customer_reservations(Request $request)
    {
        $reservation = $this->reservationRepository->customerReservations();

        return $this->sendResponse(new ReservationCollection($reservation), "");
    }
}
