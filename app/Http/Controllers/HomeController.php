<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Edujugon\PushNotification\PushNotification;

class HomeController extends Controller
{
  public function test()
  {
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
