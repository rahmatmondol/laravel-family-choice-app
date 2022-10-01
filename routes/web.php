<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

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

Route::get('/test', [HomeController::class,'test']);

Route::get('/', function () {

  return redirect()->route('admin.login');
  return view('welcome');
})->name('home');


$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($router) {
  $router->get('app-logs', 'LogViewerController@index');
});


Route::get('stripe', [StripeController::class, 'stripe']);
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');

require 'admin.php';
require 'school.php';
