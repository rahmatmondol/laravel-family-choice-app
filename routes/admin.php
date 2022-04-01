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
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => "Auth", 'middleware' => 'guest'], function () {
      #login
      Route::get('login', 'LoginController@showLoginForm')->name('login');

      Route::post('login-post', 'LoginController@login')->name('login-post');
    });

    // Route::get('/', 'Admin\Auth\LoginController@showLoginForm')->name('home');

    // Route::get('/', 'Admin\DashboardController@dashboard')->name('home');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {

      Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

      //   #start profile
      Route::get('logout', 'DashboardController@logout')->name('logout');
      //   Route::get('edit-profile', 'ProfileController@edit_profile')->name('edit_profile');
      //   Route::put('edit-profile-post', 'ProfileController@edit_profile_post')->name('edit_profile_post');

      //   Route::get('roles/export', 'RoleController@export')->name('roles.export');
      //   Route::get('admins/export', 'AdminController@export')->name('admins.export');
      //   Route::get('schools/export', 'SchoolController@export')->name('schools.export');
      //   Route::get('grades/export', 'GradeController@export')->name('grades.export');
      //   Route::get('subjects/export', 'SubjectController@export')->name('subjects.export');
      //   Route::get('users/export', 'SubjectController@export')->name('users.export');
      //   Route::get('principals/export', 'PrincipalController@export')->name('principals.export');

      //   #users reservations
      //   Route::get('reservations/export', 'UserReservationController@export')->name('reservations.export');
      //   Route::resource('reservations', 'UserReservationController')->except(['edit', 'update', 'destroy']);
      //   Route::post('reservations/accept-reservation/{reservation}', 'UserReservationController@accept_reservation')->name('reservations.accept_reservation');
      //   Route::post('reservations/reject-reservation/{reservation}', 'UserReservationController@reject_reservation')->name('reservations.reject_reservation');

      //   #principals reservations
      //   Route::get('principal/reservations/export', 'PrincipalReservationController@export')->name('principal.reservations.export');
      //   Route::get('principal/reservations', 'PrincipalReservationController@index')->name('principal.reservations.index');
      //   Route::get('principal/reservations/{reservation}', 'PrincipalReservationController@show')->name('principal.reservations.show');
      //   Route::post('principal/reservations/accept-reservation/{reservation}', 'PrincipalReservationController@accept_reservation')->name('principal.reservations.accept_reservation');
      //   Route::post('principal/reservations/reject-reservation/{reservation}', 'PrincipalReservationController@reject_reservation')->name('principal.reservations.reject_reservation');

      Route::resources([
        'admins' => 'AdminController',
        'roles' => 'RoleController',
        'customers' => 'CustomerController',
        'cities' => 'CityController',
        'schools' => 'SchoolController',
        'grades' => 'GradeController',
        'educationalSubjects' => 'EducationalSubjectController',
        'educationTypes' => 'EducationTypeController',
        'schoolTypes' => 'SchoolTypeController',
        // 'user_types' => 'UserTypeController',
        // 'users' => 'UserController',
        // 'principals' => 'PrincipalController',
        'sliders' => 'SliderController',
        // 'backgrounds' => 'BackgroundController',
      ]);
      // });

      // Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => "User"], function () {

      //   Route::get('/signin', 'AuthController@signin')->name('signin');
      //   Route::get('/callback', 'AuthController@callback')->name('callback');
      //   Route::get('/signout', 'AuthController@signout')->name('signout');
    });
  }
);
