<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\SchoolTypeController;
use App\Http\Controllers\Admin\UserManualController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\EducationTypeController;
use App\Http\Controllers\Admin\School\SchoolController;
use App\Http\Controllers\Admin\ReservationLogsController;
use App\Http\Controllers\Admin\EducationalSubjectController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\GradeFeesController;
use App\Http\Controllers\Admin\NurseryFeesController;
use App\Http\Controllers\Admin\PaidServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionTypeController;
use App\Http\Controllers\Admin\TransportationController;
use App\Http\Controllers\Admin\WalletController;

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');


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

      Route::post('login-post', [LoginController::class, 'login'])->name('login-post');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {

      Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

      //   #start profile
      Route::get('logout', [DashboardController::class, 'logout'])->name('logout');

      Route::get('reservations/export', [ReservationController::class, 'export'])->name('reservations.export');

      Route::get('wallets/index', [WalletController::class, 'index'])->name('wallets.index');

      Route::resources([
        'admins'                => AdminController::class,
        'roles'                 => RoleController::class,
        'customers'             => CustomerController::class,
        'cities'                => CityController::class,
        'types'                 => TypeController::class,
        'subscriptions'         => SubscriptionController::class,
        'subscriptionTypes'     => SubscriptionTypeController::class,
        'schools'               => SchoolController::class,
        'grades'                => GradeController::class,
        'gradeFees'             => GradeFeesController::class,
        'services'              => ServiceController::class,
        'paidServices'          => PaidServiceController::class,
        'educationalSubjects'   => EducationalSubjectController::class,
        'educationTypes'        => EducationTypeController::class,
        'schoolTypes'           => SchoolTypeController::class,
        'schools.subscriptions' => School\SubscriptionController::class,
        'schools.grades'        => School\GradeController::class,
        'courses'               => CourseController::class,
        'nurseryFees'           => NurseryFeesController::class,
        'transportations'       => TransportationController::class,
        'sliders'               => SliderController::class,
        'user_manuals'          => UserManualController::class,
        'attachments'           => AttachmentController::class,
        'reservations'          => ReservationController::class,
      ]);

      Route::get('settings', [SettingController::class, 'settings'])->name('settings');
      Route::put('settings.update', [SettingController::class, 'update'])->name('settings-update');

      Route::get('payments/export', [PaymentController::class, 'export'])->name('payments.export');
      Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');

      Route::get('reservation-logs', [ReservationLogsController::class, 'index'])->name('reservation-logs');


      // Route::resource('settings', 'SettingController')->only(['edit', 'update']);
      // Route::get('edit-settings', 'SettingController@edit')->name('edit-settings');
      // Route::get('update-settings', 'SettingController@update')->name('update-settings');

      Route::get('schools/deleteImage/{id}', [SchoolController::class, 'deleteImage']);
    });

    // reset password
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'guest:admin'], function () {
      Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
      Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
      Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
      Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    });
  }
);
