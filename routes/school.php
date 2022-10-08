<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\School\GradeController;
use App\Http\Controllers\School\CourseController;
use App\Http\Controllers\School\DashboardController;
use App\Http\Controllers\School\AttachmentController;
use App\Http\Controllers\School\Auth\LoginController;
use App\Http\Controllers\School\ReservationController;
use App\Http\Controllers\School\ReservationLogsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\School\Auth\ForgotPasswordController;
use App\Http\Controllers\School\PaymentController;

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
      Route::get('login', [LoginController::class,'showLoginForm'])->name('login');

      Route::post('login-post', [LoginController::class,'login'])->name('login-post');
    });

    Route::group(['prefix' => 'school', 'as' => 'school.', 'namespace' => "School", 'middleware' => 'auth:school'], function () {

      Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('dashboard');

      Route::get('logout', [DashboardController::class,'logout'])->name('logout');
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

      Route::get('reservations/export', [ReservationController::class,'export'])->name('reservations.export');

      Route::resources([
        'courses'             => CourseController::class,
        'attachments'         => AttachmentController::class,
        'reservations'        => ReservationController::class,
        'grades'              => GradeController::class,
      ]);

      #payments
      Route::get('payments/export', [PaymentController::class, 'export'])->name('payments.export');
      Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');

      Route::get('reservations/customers/{customer}', [ReservationController::class,'show_customer'])->name('customers.show');
      Route::get('reservation-logs', [ReservationLogsController::class,'index'])->name('reservation-logs');
    });

    // reset password
    Route::group(['prefix' => 'school', 'as' => 'school.', 'middleware' => 'guest:school'], function () {
      Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
      Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
      Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
      Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    });

  }
);
