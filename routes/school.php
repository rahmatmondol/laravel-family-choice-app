<?php

use App\Http\Controllers\School\BoostController;
use App\Http\Controllers\School\MarkettingConrtoller;
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

Route::get('school/login', [LoginController::class,'showLoginForm'])->name('school.login');

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
//      Route::get('login', [LoginController::class,'showLoginForm'])->name('login');

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
        'subscriptionTypes'   => SubscriptionTypeController::class,
        'nurseryFees'         => NurseryFeesController::class,
        'attachments'         => AttachmentController::class,
        'reservations'        => ReservationController::class,
        'grades'              => GradeController::class,
        'gradeFees'           => GradeFeesController::class,
        'transportations'     => TransportationController::class,
        'paidServices'        => PaidServiceController::class,
        // 'services'            => ServiceController::class, // TODO MAM: make services for school
      ]);

      #payments
      Route::get('payments/export', [PaymentController::class, 'export'])->name('payments.export');
      Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');

      Route::get('reservations/customers/{customer}', [ReservationController::class,'show_customer'])->name('customers.show');
      Route::get('reservation-logs', [ReservationLogsController::class,'index'])->name('reservation-logs');

      Route::get('/discount/List',[MarkettingConrtoller::class,'moreOrderView'])->name('discount.view');
      Route::get('/discount/show/{id}',[MarkettingConrtoller::class,'discountView'])->name('discount.show');
      Route::get('/discount/add',[MarkettingConrtoller::class,'addOrderView'])->name('discount.add');
      Route::delete('discount/delete/{id}',[MarkettingConrtoller::class,'distroy'])->name('discount.delete');
      Route::get('/discount/create',[MarkettingConrtoller::class,'addOrderView'])->name('discount.create');
        Route::post('/discount/store', [MarkettingConrtoller::class, 'store'])->name('discount.store');

      Route::get('/boost/list',[BoostController::class,'moreOrderView'])->name('boost.list');
      Route::get('/boost/show/{id}',[BoostController::class,'boostView'])->name('boost.show');
      Route::get('/boost/crate',[BoostController::class,'addOrderView'])->name('boost.create');
      Route::delete('/boost/delete/{id}',[BoostController::class,'distroy'])->name('boost.delete');
      Route::post('/boost/store',[BoostController::class,'store'])->name('boost.store');
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
