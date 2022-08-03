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

    Route::group(['prefix' => 'school', 'as' => 'school.', 'namespace' => "School", 'middleware' => 'auth:school'], function () {

      Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

      Route::get('logout', 'DashboardController@logout')->name('logout');
      # start profile
      Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::controller(ProfileController::class)->group(function () {
          Route::get('show', 'show')->name('show');
          Route::get('edit', 'edit')->name('edit');
          Route::put('update', 'update')->name('update');
          Route::get('deleteImage/{id}', 'deleteImage');
          Route::get('change-password', 'changePassword')->name('change-password');
          Route::post('change-password-post', 'changePasswordPost')->name('change-password-post');
        });
      });

      Route::resources([
        'courses'             => 'CourseController',
        'attachments'         => 'AttachmentController',
        'reservations'        => 'ReservationController',
        'grades'              => 'GradeController',
      ]);

      Route::get('reservations/customers/{customer}', 'ReservationController@show_customer')->name('customers.show');
    });
  }
);
