<?php

namespace App\Http\Controllers\Admin;

use App\Models\School;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\ReservationRepositoryInterface;
use App\Http\Requests\Admin\ReservationFormRequest;

class ReservationController extends BaseController
{

  public function __construct(
    private ReservationRepositoryInterface $reservationRepository,
    private SchoolRepositoryInterface $schoolRepository,
    private CourseRepositoryInterface $courseRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_reservations'])->only('index');
    $this->middleware(['permission:create_reservations'])->only('create');
    $this->middleware(['permission:update_reservations'])->only('edit');
    $this->middleware(['permission:delete_reservations'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);
    $schools = $this->schoolRepository->getAllSchools();
    // $courses = $this->courseRepository->getCourses($request);
    $reservations = $this->reservationRepository->getFilteredReservations($request);

    return view($this->mainViewPrefix.'.reservations.index', compact('reservations', 'schools'));
  } // end of index

  public function show($reservation)
  {
    $reservation = $this->reservationRepository->getReservationById($reservation);

    return view($this->mainViewPrefix.'.reservations.show', compact('reservation'));
  } //end of create

  public function edit($reservation)
  {
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

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.reservations.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
