<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  //

  public function test()
  {
    //test commit  again
    $newDateTime = Carbon::now()->subYear(2)->format('Y-m-d');

    dd($newDateTime);
  }
}
