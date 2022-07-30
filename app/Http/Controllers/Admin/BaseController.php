<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
  public  $globalAdmin;
  public  $masterLayout = "admin.layouts.master";
  public  $mainRoutePrefix = "admin";
  public  $mainViewPrefix = "admin";
  public function __construct()
  {

    // $this->middleware(['auth:admin']);

    // dd('in BaseController',$this->mainRoutePrefix,$this->masterLayout);
    View::share('masterLayout', $this->masterLayout);
    View::share('mainRoutePrefix', $this->mainRoutePrefix);
    View::share('mainViewPrefix', $this->mainViewPrefix);

    $this->middleware(function ($request, $next) {
      $this->globalAdmin = Auth::guard('admin')->user();
      View::share('globalAdmin', $this->globalAdmin);
      // dd('in BaseController',$this->globalAdmin,$this->masterLayout);
      return $next($request);
    });

  }

}
