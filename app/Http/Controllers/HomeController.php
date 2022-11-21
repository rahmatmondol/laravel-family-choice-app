<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use App\Notifications\SmsCodeNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Subscription;
use App\Notifications\Reservation\ReservationPaidNotification;
use App\Services\NotificationService;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
  public function truncate()
  {
    // Schema::disableForeignKeyConstraints();

    // $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
    // foreach ($tableNames as $name) {
    //   //if you don't want to truncate migrations
    //   if ($name == 'migrations') {
    //     continue;
    //   }
    //   DB::table($name)->truncate();
    // }

    // Schema::enableForeignKeyConstraints();

    return 'done';
  }
  public function test()
  {


    $msg = "Your Verification code is 123456";
    $msg2 = "Your Verification code is 123456";
    NotificationService::sendSms('971522946005', $msg);

    $res = Notification::route('mail', "m@gmail.com")
      ->notify(new SmsCodeNotification(115427));
    dd($res);


    $reservation = Reservation::first();

    return (new ReservationPaidNotification($reservation))
      ->toMail('mahmouddief0@gmail.com');

    $payment = Payment::firstOrCreate(
      ['payment_intent_id' => 'pi_3LnheFDynjRZ45TZ2gncG8rs', 'event_type' => 'payment_intent.succeeded'],
      ['event_object' => 'data'],
    );
    dd($payment);

    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

    dd($stripe->paymentIntents->retrieve("pi_3LnTtyDynjRZ45TZ0ek42Ocr", [])['metadata']['reservation_id']);
    // return  $stripe->paymentIntents->retrieve($this->paymentIntentId, []);


    Auth::guard('admin')->logout();
    Auth::guard('school')->logout();
    dd('done');


    dd(config('mail'));

    dd(PaymentStatus::values());
    dd(ReservationStatus::values());
    $dataIos = [
      'title' => 'test title ',
      'body' => 'tset body',
    ];

    $push = new PushNotification('fcm');

    $push->setMessage([
      'data' => $dataIos, 'notification' => $dataIos,
    ])
      ->setApiKey("AAAAXNdqSzc:APA91bFbgzD6d2oU9SwXOTckUl2Scg6wjgpkSbxWweH0yjVMN0Xzk9BCWUdtmXNOc07ystI20CZMoMhr9nyirdDrixT70sRdAuJaXZQEyayIrUlKnnsrGd12y4zQ8lSBzFnPkNx8jvmj")
      ->setDevicesToken('test')
      ->send()
      ->getFeedback();

    // Notification::create([
    //   'customer_id' => 1,
    //   'title' => $data['title'],
    //   'body' => $data['body'],
    // ]);
    // dd($push);

    dd($push);
    // \Log::info(print_r($push), true);
    return $push;
  }
}
