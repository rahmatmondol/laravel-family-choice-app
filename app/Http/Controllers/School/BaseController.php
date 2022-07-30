<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
  public  $globalSchool;
  public  $masterLayout="school.layouts.master";
  public  $sideBarItems = ['courses','attachments','reservations',];
  public function __construct()
  {

    // $this->middleware(['auth:school']);

    $this->middleware(function ($request, $next) {

      $this->globalSchool = Auth::guard('school')->user();
      // dd('in middleware',$this->globalSchool,$this->masterLayout);
      View::share('globalSchool', $this->globalSchool);
      View::share('sideBarItems', $this->sideBarItems);
      View::share('masterLayout', $this->masterLayout);
      return $next($request);
    });

  }

}
