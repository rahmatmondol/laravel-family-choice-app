<?php

use App\Enums\PaymentStatus;
use App\Enums\PaymentStep;
use App\Enums\PaymentType;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Models\Reservation;
use App\Models\School;
use App\Notifications\Reservation\UpdateReservationStatusNotification;
use Illuminate\Support\Facades\Notification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
     Artisan::call('optimize:clear');
     Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/test-mail', function () {
  $school = School::first();
  dd($school->gradeFees);

  app()->setLocale('ar');
  $reservation = Reservation::find(73);
  $data = [
    'title'           => "تم الغاء طلبك",
    'body'            => "تم  الغاء طلبك لعدم اكتمال البيانات",
    // 'customer_id'  => $customer->id,
    'click_action'    => 'ReservationDetails',
    'reservation_id'  => (int)$reservation->id,
  ];
  return view('email.customer.update_reservation_status',compact('reservation','data'));
  return Notification::send($reservation->customer, new UpdateReservationStatusNotification($reservation, $data));

  // return new UpdateReservationStatusNotification($reservation,$data);
});


Route::get('/test', [HomeController::class,'test']);



// Route::get('/truncate-all-tables', [HomeController::class,'truncate']);

Route::get('/', function () {
  // return redirect()->route('admin.login');
  return view('welcome');
})->name('home');

// https://github.com/xmartlabs/projecthub-landing/blob/master/terms-and-conditions.html
// Route::get('terms-conditions', [HomeController::class,'terms_conditions']);
Route::view('terms-conditions', 'terms_conditions');
Route::view('privacy-policy', 'privacy_policy');

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($router) {
  $router->get('app-logs', 'LogViewerController@index');
});

require 'admin.php';
require 'school.php';
