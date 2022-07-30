<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use App\Notifications\SmsCodeNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Admin\BaseController;
use Edujugon\PushNotification\PushNotification;

class HomeController extends Controller
{
  public function test()
  {


    Auth::guard('admin')->logout();
    Auth::guard('school')->logout();
    dd('done');

    Notification::route('mail', "mahmoud@g.com")
      ->notify(new SmsCodeNotification(115427));

  dd(config('mail'));

    dd(PaymentStatus::values() );
    dd(ReservationStatus::values() );
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
