<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
  [
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
      'localeSessionRedirect',
      'localizationRedirect',
      'localeViewPath'
    ]
  ],
  function () {

    # must guest
    Route::group(['prefix' => 'school', 'as' => 'school.', 'namespace' => "School\Auth", 'middleware' => 'guest:school'], function () {
      #login
      Route::get('login', 'LoginController@showLoginForm')->name('login');

      Route::post('login-post', 'LoginController@login')->name('login-post');
    });

    Route::group(['prefix' => 'school', 'as' => 'school.','namespace' => "School", 'middleware' => 'auth:school'], function () {

      Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

      //   #start profile
      Route::get('logout', 'DashboardController@logout')->name('logout');

      Route::resources([
        'courses'             => 'CourseController',
        'schools'             => 'School\SchoolController',
        'attachments'         => 'AttachmentController',
        'reservations'        => 'ReservationController',
      ]);

      Route::get('reservations/customers/{customer}', 'ReservationController@show_customer')->name('customers.show');
      Route::get('schools/deleteImage/{id}', 'SchoolController@deleteImage');
    });
  }
);
