<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Principal;
use App\Models\Reservation;
use App\Models\School;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth:admin']);
  }


  public function dashboard(Request $request)
  {
    return view('admin.dashboard');
  }


  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    return redirect()->route('admin.login');
  }
}
