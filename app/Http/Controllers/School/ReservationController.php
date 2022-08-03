<?php

namespace App\Http\Controllers\School;

use App\Models\School;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CourseRepositoryInterface;
use App\Http\Controllers\School\BaseController;
use App\Interfaces\ReservationRepositoryInterface;
use App\Http\Requests\Admin\ReservationFormRequest;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use App\Models\Customer;

class ReservationController extends BaseController
{

  public function __construct(
    private ReservationRepositoryInterface $reservationRepository,
    private CourseRepositoryInterface $courseRepository,
    private CustomerRepositoryInterface $customerRepository
  ) {
    parent::__construct();
    //create read update delete
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);
    $reservations = $this->reservationRepository->getFilteredReservations($request);

    return view($this->mainViewPrefix.'.reservations.index', compact('reservations', ));
  } // end of index

  public function show($reservation)
  {
    if (!Gate::allows('show-reservation', $reservation)) {
      abort(403);
    }
    $reservation = $this->reservationRepository->getReservationById($reservation);

    return view($this->mainViewPrefix.'.reservations.show', compact('reservation'));
  } //end of create

  public function edit($reservation)
  {
    if (!Gate::allows('show-reservation', $reservation)) {
      abort(403);
    }
    $reservation = $this->reservationRepository->getReservationById($reservation);

    return view($this->mainViewPrefix.'.reservations.edit', compact('reservation',));
  } //end of edit

  public function update(ReservationFormRequest $request, Reservation $reservation)
  {
    $this->reservationRepository->updateReservation($request, $reservation);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.reservations.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Reservation $reservation)
  {
    if (!$reservation) {
      return redirect()->back();
    }
    $this->reservationRepository->deleteReservation($reservation);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.reservations.index', ['page' => session('currentPage')]);
  } //end of destroy

  public function show_customer($customer)
  {
    $customer = $this->customerRepository->getCustomerById($customer);

    return view($this->mainViewPrefix.'.reservations.customer_details', compact('customer'));
  } //end of create


}//end of controller
