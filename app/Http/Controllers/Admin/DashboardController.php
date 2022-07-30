<?php

namespace App\Http\Controllers\Admin;



use App\Models\City;
use App\Models\Grade;
use App\Models\Course;
use App\Models\School;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
  private $id ;
  public function __construct()
  {
    $this->middleware(['auth:admin']);

    $this->middleware('auth');
    $this->middleware(function ($request, $next) {
        $this->id = Auth::user();
        return $next($request);
    });

  }

  public function dashboard(Request $request)
  {
    $countAllReservation = Reservation::count();
    $countPendingReservations = Reservation::whenStatus(ReservationStatus::Pending->value)->count();
    $countOfCities = City::count();
    $countOfSchools = School::count();
    $countOfCourses = Course::count();
    $countOfGrades = Grade::count();
    $countOfServices = Service::count();
    $countCustomers = Customer::count();
    $newCustomers = Customer::latest()->limit(8)->get();

    $reservationData = Reservation::select(
      DB::raw('YEAR(created_at) as year'),
      DB::raw('MONTH(created_at) as month'),
      DB::raw('SUM(total_fees) as sum')
    )->groupBy('month')
      ->get();
    return view('admin.dashboard', compact(
      'countAllReservation',
      'countPendingReservations',
      'countOfCities',
      'countOfSchools',
      'countOfCourses',
      'countOfGrades',
      'countOfServices',
      'countCustomers',
      'newCustomers',
      'reservationData',
    ));
  }

  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();
    // $request->session()->invalidate();
    return redirect()->route('admin.login');
  }
}
