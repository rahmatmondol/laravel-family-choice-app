<?php

namespace App\Http\Controllers\School;


use App\Models\Course;
use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\School\BaseController;

class DashboardController extends BaseController
{
  public function __construct()
  {
    parent::__construct();
  }

  public function dashboard(Request $request)
  {
    $countAllReservation = Reservation::whenSchool($this->globalSchool->id)->count();
    $countPendingReservations = Reservation::whenSchool($this->globalSchool->id)->whenStatus(ReservationStatus::Pending->value)->count();
    $latestReservations = Reservation::whenSchool($this->globalSchool->id)->latest()->limit(8)->get();
    $countOfCourses = Course::whenSchool($this->globalSchool->id)->count();
    $countOfGrades = $this->globalSchool->grades()->count();

    $reservationData = Reservation::whenSchool($this->globalSchool->id)
      ->select(
        DB::raw('YEAR(created_at) as year'),
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(total_fees) as sum')
      )->groupBy('month')
      ->get();
    return view($this->mainViewPrefix.'.dashboard', compact(
      'countAllReservation',
      'countPendingReservations',
      'latestReservations',
      'countOfCourses',
      'reservationData',
      'countOfGrades',
    ));
  }

  public function logout(Request $request)
  {
    Auth::guard('school')->logout();
    // $request->session()->invalidate();
    return redirect()->route('school.login');
  }
}
