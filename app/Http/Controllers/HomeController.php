<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  //

  public function test()
  {
    $newDateTime = Carbon::now()->subYear(2)->format('Y-m-d');

    dd($newDateTime);
  }
}
