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

    // Route::post('/getCity', 'PublicController@getCity')->name('getCity');
    // // Route::post('/states', 'PublicController@states')->name('states');
    // // Route::post('/regoins', 'PublicController@regoins')->name('regoins');

    // authentication
    Route::group([
      'namespace' => 'Customer'
    ], function () {
      // Route::post('social_login', 'Customer\AuthController@social_login');
      Route::post('signup-customer', 'AuthController@signupCustomer');
      // Route::post('sendSms', 'SmsController@sendSms');
      Route::post('login', 'AuthController@login');

      #register
      Route::post('send-code', 'AuthController@sendCode');
      Route::post('get-verificatin-code', 'AuthController@getVerificationCode');
      Route::post('verify-phone', 'AuthController@verifyPhone');
      Route::post('foreget-password', 'AuthController@foregetPassword');
      Route::post('/cities', 'PublicController@cities')->name('cities');
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

      Route::post('reserve_provider', 'CustomerController@reserve_provider');
      Route::post('customer_reservations', 'CustomerController@customer_reservations');

      Route::post('/toggle_favorite', 'FavoirteController@toggle_favorite')->name('toggle_favorite');
      Route::post('/favoirtes', 'FavoirteController@favoirtes')->name('favoirtes');

      Route::get('logout', 'AuthController@logout');
      Route::post('change-password', 'AuthController@changePassword');
      Route::post('update-firebase-token', 'AuthController@updateFirebaseToken');
      Route::get('profile', 'AuthController@profile');
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
