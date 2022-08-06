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
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => "Auth", 'middleware' => 'guest:admin'], function () {
      #login
      Route::get('login', 'LoginController@showLoginForm')->name('login');

      Route::post('login-post', 'LoginController@login')->name('login-post');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {

      Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

      //   #start profile
      Route::get('logout', 'DashboardController@logout')->name('logout');

      Route::get('reservations/export', 'ReservationController@export')->name('reservations.export');

      Route::resources([
        'admins'              => 'AdminController',
        'roles'               => 'RoleController',
        'customers'           => 'CustomerController',
        'cities'              => 'CityController',
        'types'               => 'TypeController',
        'schools'             => 'School\SchoolController',
        'grades'              => 'GradeController',
        'services'            => 'ServiceController',
        'educationalSubjects' => 'EducationalSubjectController',
        'educationTypes'      => 'EducationTypeController',
        'schoolTypes'         => 'SchoolTypeController',
        'schools.grades'      => 'School\GradeController',
        'courses'             => 'CourseController',
        'sliders'             => 'SliderController',
        'user_manuals'        => 'UserManualController',
        'attachments'         => 'AttachmentController',
        'reservations'         => 'ReservationController',
      ]);

      // Route::resource('settings', 'SettingController')->only(['edit', 'update']);
      // Route::get('edit-settings', 'SettingController@edit')->name('edit-settings');
      // Route::get('update-settings', 'SettingController@update')->name('update-settings');

      Route::get('schools/deleteImage/{id}', 'School\SchoolController@deleteImage');
    });
  }
);
