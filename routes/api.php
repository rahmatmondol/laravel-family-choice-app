<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

// composer require laravel/passport  "7.5.1"

Route::group(
  [
    'namespace' => "Api", 'middleware' => 'localization',
  ],
  function () {
    #guest
    Route::group([
      'namespace' => 'Customer'
    ], function () {

      # authentication
      Route::controller(AuthController::class)->group(function () {
        Route::post('signup-customer', 'signupCustomer');
        Route::post('login', 'login');
        Route::post('send-code', 'sendCode');
        Route::post('get-verificatin-code', 'getVerificationCode');
        Route::post('verify-phone', 'verifyPhone');
        Route::post('foreget-password', 'foregetPassword');
      });

      Route::controller(PublicController::class)->group(function () {
        Route::get('user-manuals', 'userManuals');
        Route::get('contact-support', 'contactSupport');
        Route::get('cities', 'cities');
        Route::get('types', 'types');
        Route::get('get-filter-data', 'filterData');
        Route::get('sliders', 'sliders');
      });

      Route::controller(SchoolController::class)->group(function () {
        Route::get('schools', 'schools');
        Route::get('courses', 'courses');
        Route::get('school-reviews', 'school_reviews');
      });
    });


    #forget password
    // Route::post('customer/sendVerificationCodeForegetPassword', 'CustomerController@sendVerificationCodeForegetPassword')->name('sendVerificationCodeForegetPassword');
    // Route::post('customer/verifyCodeForegetPassword', 'CustomerController@verifyCodeForegetPassword')->name('verifyCodeForegetPassword');
    // Route::post('customer/foregetPassword', 'CustomerController@foregetPassword')->name('foregetPassword');

    // Route::post('/categories', 'PublicController@categories')->name('categories');
    // Route::post('/subcategories', 'PublicController@subcategories')->name('subcategories');
    // Route::post('/providers', 'ProviderController@providers')->name('providers');
    // Route::post('/providerDetails', 'ProviderController@providerDetails')->name('providerDetails');
    // Route::post('/offers', 'PublicController@offers')->name('offers');
    // Route::post('/providerGallary', 'ProviderController@providerGallary')->name('providerGallary');
    // Route::post('/offers', 'PublicController@offers')->name('offers');
    // Route::post('/reviews', 'PublicController@reviews')->name('reviews');
    // // Route::post('/searchProduct', 'PublicController@searchProduct')->name('searchProduct');
    // Route::post('/staticPages', 'PublicController@staticPages')->name('staticPages');
    // Route::post('/contactUs', 'PublicController@contactUs')->name('contactUs');

    // Route::post('/blogs', 'NewsController@blogs')->name('blogs');
    // Route::post('/sliders', 'PublicController@sliders')->name('sliders');

    Route::group(['namespace' => "Customer", 'prefix' => 'customer/', 'middleware' => ['auth:customer-api', 'ensureCustomerVerified']], function () {

      Route::controller(AuthController::class)->group(function () {
        Route::put('edit-customer-profile', 'editCustomerProfile');
        Route::get('logout', 'logout');
        Route::post('change-password', 'changePassword');
        Route::post('update-firebase-token', 'updateFirebaseToken');
        Route::get('profile', 'profile');
      });

      Route::post('setReview', 'CustomerController@setReview');

      #favorites
      Route::controller(FavoirteController::class)->group(function () {
        Route::post('toggle-favorite', 'toggle_favorite');
        Route::get('favorites', 'favorites');
      });

      #review
      Route::controller(ReviewController::class)->group(function () {
        Route::post('set-review', 'setReview');
        Route::get('reviews-list', 'reviewsList');
        Route::delete('delete-review', 'deleteReview');
      });

      #reserve school
      Route::controller(ReservationsController::class)->group(function () {
        Route::get('school-attachments', 'school_attachments');
        Route::post('add-reservation', 'add_reservation');
        Route::put('update-reservation', 'update_reservation');
        Route::get('customer-reservations', 'customer_reservations');
      });
    });
  }
);

Route::group([
  'namespace' => 'API\Customer',
  'middleware' => 'api',
  'prefix' => 'password'
], function () {
  // Route::post('create', 'PasswordResetController@create');
  // Route::get('find/{token}', 'PasswordResetController@find');
  // Route::post('reset', 'PasswordResetController@reset');
});
