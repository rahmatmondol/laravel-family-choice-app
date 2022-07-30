<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
  public  $globalAdmin;
  public  $masterLayout = "admin.layouts.master";
  public  $sideBarItems = ['courses','attachments','reservations',];
  public function __construct()
  {

    $this->middleware(['auth:admin']);

    $this->middleware(function ($request, $next) {

      $this->globalAdmin = Auth::user();
      View::share('globalAdmin', $this->globalAdmin);
      View::share('sideBarItems', $this->sideBarItems);
      View::share('masterLayout', $this->masterLayout);
      // dd('in middleware',$this->globalAdmin,$this->masterLayout);
      return $next($request);
    });

  }

}
