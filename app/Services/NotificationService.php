<?php

namespace App\Services;

use Exception;
use App\Models\Notification;
use App\Notifications\Reservation\UpdateReservationStatusNotification;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotificationService
{

  public static function storeReservationNotificationList($data, $customer_id, $reservation_id)
  {
    Notification::create([
      'customer_id'     => $customer_id,
      'reservation_id'  => $reservation_id,
      'title'           => $data['title'],
      'body'            => $data['body'],
    ]);
  }

  public static function notificationList(){
    return getCustomer()->notifications()->latest()->paginate(request()->perPage ?? 20);
  }

  public static  function  sendReservationNotification($status, $customer, $reservation)
  {
    $changes = $reservation->getChanges();
    if (isset($changes['status']) || isset($changes['reason_of_refuse'])) {
      $notificationDetails = self::getReservationStatusNotificationDetails($status, $reservation);

      $data = [
        'title'           => $notificationDetails[0],
        'body'            => $notificationDetails[1],
        'customer_id'     => $customer->id,
        'reservation_id'  => $reservation->id,
      ];

      $push = new PushNotification('fcm');

      try {
        $push->setMessage([
          'data' => $data, 'notification' => $data,
        ])->setApiKey(env('NOTIFICATION_API_KEY'))
          ->setDevicesToken($customer->firebaseToken)
          ->send()
          ->getFeedback();

        self::storeReservationNotificationList($data, $customer->id, $reservation->id);

        $res  = FacadesNotification::send($reservation->customer, new UpdateReservationStatusNotification($reservation,$data));

      } catch (Exception $e) {
        info($e->getMessage());
      }
      return $push;
    }
  }

  public static function getReservationStatusNotificationDetails($status = 'pending', $reservation)
  {
    $messages = [
      'pending' => [
        __('site.New Reservation'),
        __('site.pending_reservation_body', ['reservation_number' => $reservation->id])
      ],
      'accepted' => [
        __('site.Your reservation is accepted'),
        __('site.accepted_reservation_body', ['reservation_number' => $reservation->id])
      ],
      'rejected' => [
        __('site.Your reservation is rejected'),
        $reservation->reason_of_refuse
      ],
    ];

    return $messages[$status];
  }
}
