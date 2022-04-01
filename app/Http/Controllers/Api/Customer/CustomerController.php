<?php

namespace App\Http\Controllers\API\Customer;

use Exception;
use App\Provider;

use Illuminate\Http\Request;
use App\Mail\ReservationMail;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;
use App\Http\Resources\ReservationResource;

class CustomerController extends Controller
{

  use ResponseTrait;

  public $customer;
  public function __construct()
  {
    $this->customer = getCustomer();
  }

  public function setReview(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'comment' => 'required',
      'provider_id' => 'required|exists:providers,id|',
      'review' => 'required|integer|min:1|max:5',
    ]);

    if ($validator->fails()) {
      return $this->sendError(' ', $validator->errors());
    }

    getCustomer()->reviews()->updateOrCreate(
      ['provider_id' => request('provider_id')],
      ['review' => request('review'), 'comment' => request('comment')]
    );

    $this->updateProviderReviw(request()->provider_id);

    return $this->sendResponse("", __('site.added_successfully'));
  }

  public function reserve_provider(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'date_time' => ['required', 'date_format:Y-m-d H:i:s'],
      'provider_id' => 'required|exists:providers,id',
      'description' => ['required']
    ]);

    if ($validator->fails()) {
      return $this->sendError(' ', $validator->errors());
    }

    $provider = Provider::findOrFail($request->provider_id);
    getCustomer()->reservations()->create($request->only(['provider_id', 'date_time', 'description', 'full_name', 'email', 'phone']));

    try {

      // sendEMail("test msg", "mahmouddief0@gmail.com", "test subject");

      // Mail::to($provider->email)->send(
      //   new ReservationMail($request->full_name, $request->email, $request->phone, $request->date_time, $request->description)
      // );
    } catch (Exception $e) {
      Log::info($e);
    }

    return $this->sendResponse("", __('site.added_successfully'));
  }

  public function customer_reservations(Request $request)
  {
    $reservations = $this->customer->reservations()->latest()->get();
    return $this->sendResponse(ReservationResource::collection($reservations), "");
  }

  public function updateProviderReviw($provider_id)
  {
    $provider = Provider::find($provider_id);

    $total_number_review = $provider->reviews()->count();

    $review = $provider->reviews()->avg('review');

    $provider->update(['review' => $review, 'total_number_review' => $total_number_review]);
  }
}
