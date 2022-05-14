<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait NotificationTrait
{
  # upload image
  // function uploadImages($data, $customer)
  // {
  //   $dataIos = [
  //     'title' => $data['title'],
  //     'body' => $data['body'],
  //   ];

  //   $push = new PushNotification('fcm');

  //   $push->setMessage([
  //     'data' => $data, 'notification' => $dataIos,
  //   ])
  //     ->setApiKey("AAAAXNdqSzc:APA91bFbgzD6d2oU9SwXOTckUl2Scg6wjgpkSbxWweH0yjVMN0Xzk9BCWUdtmXNOc07ystI20CZMoMhr9nyirdDrixT70sRdAuJaXZQEyayIrUlKnnsrGd12y4zQ8lSBzFnPkNx8jvmj")
  //     ->setDevicesToken($customer->firebaseToken)
  //     ->send()
  //     ->getFeedback();

  //   Notification::create([
  //     'customer_id' => $customer->id,
  //     'title' => $data['title'],
  //     'body' => $data['body'],
  //   ]);
  //   // dd($push);

  //   // dd($push);
  //   // \Log::info(print_r($push), true);
  //   return $push;
  // }
}
