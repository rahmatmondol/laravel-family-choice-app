<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ReservationRepositoryInterface;
use App\Http\Requests\Admin\ReservationFormRequest;

class ReservationController extends Controller
{

  public function __construct(
    private ReservationRepositoryInterface $reservationRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_reservations'])->only('index');
    $this->middleware(['permission:create_reservations'])->only('create');
    $this->middleware(['permission:update_reservations'])->only('edit');
    $this->middleware(['permission:delete_reservations'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $reservations = $this->reservationRepository->getFilteredReservations($request);

    return view('admin.reservations.index', compact('reservations'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view('admin.reservations.create', compact('roles'));
  } //end of create

  public function show($reservation)
  {
    $reservation = $this->reservationRepository->getReservationById($reservation);

    return view('admin.reservations.show', compact('reservation'));
  } //end of create

  // new Enum(TicketStatus::class)]
  public function store(ReservationFormRequest $request)
  {
    $this->reservationRepository->createReservation($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route('admin.reservations.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($reservation)
  {

    $reservation = $this->reservationRepository->getReservationById($reservation);

    return view('admin.reservations.edit', compact('reservation',));
  } //end of edit

  public function update(ReservationFormRequest $request, Reservation $reservation)
  {
    $this->reservationRepository->updateReservation($request, $reservation);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route('admin.reservations.index', ['page' => session('currentPage')]);
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
    return redirect()->route('admin.reservations.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
