<?php

use Illuminate\Http\Request;

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
      // Route::post('social_login', 'Customer\AuthController@social_login');
      // Route::post('sendSms', 'SmsController@sendSms');
      Route::post('signup-customer', 'AuthController@signupCustomer');
      Route::post('login', 'AuthController@login');
      Route::post('send-code', 'AuthController@sendCode');
      Route::post('get-verificatin-code', 'AuthController@getVerificationCode');
      Route::post('verify-phone', 'AuthController@verifyPhone');
      Route::post('foreget-password', 'AuthController@foregetPassword');

      Route::get('user-manuals', 'PublicController@userManuals');
      Route::get('contact-support', 'PublicController@contactSupport');
      Route::get('cities', 'PublicController@cities');
      Route::get('types', 'PublicController@types');
      Route::get('get-filter-data', 'PublicController@filterData');
      Route::get('sliders', 'PublicController@sliders');
      Route::get('schools', 'SchoolController@schools');
      Route::get('courses', 'SchoolController@courses');
      Route::get('school-reviews', 'SchoolController@school_reviews');
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

      Route::put('edit-customer-profile', 'AuthController@editCustomerProfile');
      Route::post('setReview', 'CustomerController@setReview');

      #favorites
      Route::post('toggle-favorite', 'FavoirteController@toggle_favorite')->name('toggle_favorite');
      Route::get('favorites', 'FavoirteController@favorites')->name('favorites');

      #review
      Route::post('set-review', 'ReviewController@setReview');
      Route::get('reviews-list', 'ReviewController@reviewsList');
      Route::delete('delete-review', 'ReviewController@deleteReview');

      Route::get('logout', 'AuthController@logout');
      Route::post('change-password', 'AuthController@changePassword');
      Route::post('update-firebase-token', 'AuthController@updateFirebaseToken');
      Route::get('profile', 'AuthController@profile');

      #reserve school
      Route::get('school-attachments', 'ReservationsController@school_attachments');
      Route::post('add-reservation', 'ReservationsController@add_reservation');
      Route::put('update-reservation', 'ReservationsController@update_reservation');
      Route::get('customer-reservations', 'ReservationsController@customer_reservations');
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
