<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/test', "HomeController@test");

Route::get('/', function () {

  return redirect()->route('admin.login');
  return view('welcome');
})->name('home');


$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($router) {
  $router->get('logs', 'LogViewerController@index');
});

require 'admin.php';
require 'school.php';
