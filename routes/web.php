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

require 'admin.php';
require 'school.php';
