<?php

use App\Http\Controllers\Api\Customer\DocumentController;
use App\Http\Controllers\Api\Customer\FavoriteController;
use App\Http\Controllers\Api\Customer\NotificationController;
use App\Http\Controllers\Api\Customer\StripePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

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

      Route::controller(StripePaymentController::class)->prefix('stripe')->group(function () {
        Route::post('webhook', 'paymentWebHook');
        Route::post('refund-partial-payment-webhook', 'refundPartialPaymentWebhook');
      });

      Route::controller(PublicController::class)->group(function () {
        Route::get('user-manuals', 'userManuals');
        Route::get('contact-support', 'contactSupport');
        Route::get('cities', 'cities');
        Route::get('types', 'types');
        Route::get('types', 'types');
        Route::get('get-filter-data', 'filterData');
        Route::get('sliders', 'sliders');
        Route::get('config-data', 'configData');
      });

      Route::controller(SchoolController::class)->group(function () {
        Route::get('schools', 'schools');
        Route::get('school-details', 'schoolDetails');
        Route::get('courses', 'courses');
        Route::get('subscription-types', 'subscriptionTypes');
        Route::get('school-reviews', 'school_reviews');
      });
    });

    Route::group(['namespace' => "Customer", 'prefix' => 'customer/', 'middleware' => ['auth:customer-api', 'ensureCustomerVerified']], function () {

      Route::controller(AuthController::class)->group(function () {
        Route::post('edit-customer-profile', 'editCustomerProfile');
        Route::get('logout', 'logout');
        Route::post('change-password', 'changePassword');
        Route::post('update-firebase-token', 'updateFirebaseToken');
        Route::get('profile', 'profile');
        Route::get('current-wallet', 'currentWallet');
        Route::post('remove-account', 'removeAccount');
      });

      Route::get('notification-list', [NotificationController::class,'notificationList']);

      #favorites
      Route::controller(FavoriteController::class)->group(function () {
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
        Route::post('update-reservation', 'update_reservation');
        Route::get('customer-reservations', 'customer_reservations');
        Route::get('reservation-details', 'reservation_details');
      });

      Route::controller(StripePaymentController::class)->group(function () {
        Route::get('get-payment-intent', 'getPaymentIntent');
      });

      // pay with wallet
      Route::controller(WalletController::class)->group(function () {
        Route::post('payment-with-wallet', 'paymentWithWallet');
      });

      Route::controller(RefundController::class)->group(function () {
        Route::post('refund-partial-payment', 'refundPartialPayment');
      });

      //Document
        Route::controller(DocumentController::class)->group(function (){
            Route::post('/add-document','save');
            Route::get('/get-document','view');
        });

    });
  }
);
