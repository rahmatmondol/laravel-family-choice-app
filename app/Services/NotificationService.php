<?php

namespace App\Services;

use Exception;
use App\Models\Notification;
use App\Notifications\Reservation\UpdateReservationStatusNotification;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Http;
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

  public static function notificationList()
  {
    return getCustomer()->notifications()->latest()->paginate(request()->perPage ?? 20);
  }

  public static function sendNotification(array $data, string $token)
  {
    $push = new PushNotification('fcm');

    $push->setMessage([
      'data' => $data, 'notification' => $data,
    ])->setApiKey(env('NOTIFICATION_API_KEY'))
      ->setDevicesToken($token)
      ->send()
      ->getFeedback();
    info(print_r($push->service->feedback, true));
    //   dd($push->service->feedback);
  }

  public static  function  sendReservationNotification($status, $reservation)
  {
    $notificationDetails = self::getReservationStatusNotificationDetails($status, $reservation);
    $customer = $reservation->customer;

    $data = [
      'title'           => $notificationDetails[0],
      'body'            => $notificationDetails[1],
      // 'customer_id'  => $customer->id,
      'click_action'    => 'ReservationDetails',
      'reservation_id'  => (int)$reservation->id,
    ];
    // dd($data);

    try {
      if (!empty($customer->firebaseToken))
        self::sendNotification($data, $customer->firebaseToken);

      self::storeReservationNotificationList($data, $customer->id, $reservation->id);

      FacadesNotification::send($reservation->customer, new UpdateReservationStatusNotification($reservation, $data));
    } catch (Exception $e) {
      info($e->getMessage());
    }
    return true;
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
      'payment_status.succeeded' => [
        __('site.Your Reservation Paid Successfully'),
        __('site.completed_reservation_body', ['reservation_number' => $reservation->id])
      ],
      'payment_status.failed' => [
        __('site.Reservation payment failed'),
        __('site.reservation_payment_failed', ['reservation_number' => $reservation->id])
      ],
      'partial_payment.succeeded' => [
        __('site.Partial payment succeeded'),
        __('site.Partial payment for reservation number succeeded', ['reservation_number' => $reservation->id])
      ],
      'partial_payment.failed' => [
        __('site.Partial payment failed'),
        __('site.Partial payment for reservation number failed', ['reservation_number' => $reservation->id])
      ],
      'remaining_payment.succeeded' => [
        __('site.Remaining payment succeeded'),
        __('site.Remaining payment for reservation number succeeded', ['reservation_number' => $reservation->id])
      ],
      'remaining_payment.failed' => [
        __('site.Remaining payment failed'),
        __('site.Remaining payment for reservation number failed', ['reservation_number' => $reservation->id])
      ],
    ];

    return $messages[$status];
  }

  public static function sendSms(string $phone, string $message)
  {
    try {
      // 971522946005 is active number for hussein
      $msg = self::convertToUnicode($message);
      $client = new \GuzzleHttp\Client(['verify' => false]);
      $request = $client->get('https://doo.ae/api/msgSend.php?mobile=971526972999&password=12345678&numbers=971' . $phone . '&sender=APPOTP&msg=' . $msg . '&applicationType=3');
      $res = $request->getBody()->getContents();
      info('result sms : ' . $res);
    } catch (Exception $e) {
      info($e->getMessage());
    }
  }

  public static  function convertToUnicode($message)
  {
    $chrArray[0] = "�";
    $unicodeArray[0] = "060C";
    $chrArray[1] = "�";
    $unicodeArray[1] = "061B";
    $chrArray[2] = "�";
    $unicodeArray[2] = "061F";
    $chrArray[3] = "�";
    $unicodeArray[3] = "0621";
    $chrArray[4] = "�";
    $unicodeArray[4] = "0622";
    $chrArray[5] = "�";
    $unicodeArray[5] = "0623";
    $chrArray[6] = "�";
    $unicodeArray[6] = "0624";
    $chrArray[7] = "�";
    $unicodeArray[7] = "0625";
    $chrArray[8] = "�";
    $unicodeArray[8] = "0626";
    $chrArray[9] = "�";
    $unicodeArray[9] = "0627";
    $chrArray[10] = "�";
    $unicodeArray[10] = "0628";
    $chrArray[11] = "�";
    $unicodeArray[11] = "0629";
    $chrArray[12] = "�";
    $unicodeArray[12] = "062A";
    $chrArray[13] = "�";
    $unicodeArray[13] = "062B";
    $chrArray[14] = "�";
    $unicodeArray[14] = "062C";
    $chrArray[15] = "�";
    $unicodeArray[15] = "062D";
    $chrArray[16] = "�";
    $unicodeArray[16] = "062E";
    $chrArray[17] = "�";
    $unicodeArray[17] = "062F";
    $chrArray[18] = "�";
    $unicodeArray[18] = "0630";
    $chrArray[19] = "�";
    $unicodeArray[19] = "0631";
    $chrArray[20] = "�";
    $unicodeArray[20] = "0632";
    $chrArray[21] = "�";
    $unicodeArray[21] = "0633";
    $chrArray[22] = "�";
    $unicodeArray[22] = "0634";
    $chrArray[23] = "�";
    $unicodeArray[23] = "0635";
    $chrArray[24] = "�";
    $unicodeArray[24] = "0636";
    $chrArray[25] = "�";
    $unicodeArray[25] = "0637";
    $chrArray[26] = "�";
    $unicodeArray[26] = "0638";
    $chrArray[27] = "�";
    $unicodeArray[27] = "0639";
    $chrArray[28] = "�";
    $unicodeArray[28] = "063A";
    $chrArray[29] = "�";
    $unicodeArray[29] = "0641";
    $chrArray[30] = "�";
    $unicodeArray[30] = "0642";
    $chrArray[31] = "�";
    $unicodeArray[31] = "0643";
    $chrArray[32] = "�";
    $unicodeArray[32] = "0644";
    $chrArray[33] = "�";
    $unicodeArray[33] = "0645";
    $chrArray[34] = "�";
    $unicodeArray[34] = "0646";
    $chrArray[35] = "�";
    $unicodeArray[35] = "0647";
    $chrArray[36] = "�";
    $unicodeArray[36] = "0648";
    $chrArray[37] = "�";
    $unicodeArray[37] = "0649";
    $chrArray[38] = "�";
    $unicodeArray[38] = "064A";
    $chrArray[39] = "�";
    $unicodeArray[39] = "0640";
    $chrArray[40] = "�";
    $unicodeArray[40] = "064B";
    $chrArray[41] = "�";
    $unicodeArray[41] = "064C";
    $chrArray[42] = "�";
    $unicodeArray[42] = "064D";
    $chrArray[43] = "�";
    $unicodeArray[43] = "064E";
    $chrArray[44] = "�";
    $unicodeArray[44] = "064F";
    $chrArray[45] = "�";
    $unicodeArray[45] = "0650";
    $chrArray[46] = "�";
    $unicodeArray[46] = "0651";
    $chrArray[47] = "�";
    $unicodeArray[47] = "0652";
    $chrArray[48] = "!";
    $unicodeArray[48] = "0021";
    $chrArray[49] = '"';
    $unicodeArray[49] = "0022";
    $chrArray[50] = "#";
    $unicodeArray[50] = "0023";
    $chrArray[51] = "$";
    $unicodeArray[51] = "0024";
    $chrArray[52] = "%";
    $unicodeArray[52] = "0025";
    $chrArray[53] = "&";
    $unicodeArray[53] = "0026";
    $chrArray[54] = "'";
    $unicodeArray[54] = "0027";
    $chrArray[55] = "(";
    $unicodeArray[55] = "0028";
    $chrArray[56] = ")";
    $unicodeArray[56] = "0029";
    $chrArray[57] = "*";
    $unicodeArray[57] = "002A";
    $chrArray[58] = "+";
    $unicodeArray[58] = "002B";
    $chrArray[59] = ",";
    $unicodeArray[59] = "002C";
    $chrArray[60] = "-";
    $unicodeArray[60] = "002D";
    $chrArray[61] = ".";
    $unicodeArray[61] = "002E";
    $chrArray[62] = "/";
    $unicodeArray[62] = "002F";
    $chrArray[63] = "0";
    $unicodeArray[63] = "0030";
    $chrArray[64] = "1";
    $unicodeArray[64] = "0031";
    $chrArray[65] = "2";
    $unicodeArray[65] = "0032";
    $chrArray[66] = "3";
    $unicodeArray[66] = "0033";
    $chrArray[67] = "4";
    $unicodeArray[67] = "0034";
    $chrArray[68] = "5";
    $unicodeArray[68] = "0035";
    $chrArray[69] = "6";
    $unicodeArray[69] = "0036";
    $chrArray[70] = "7";
    $unicodeArray[70] = "0037";
    $chrArray[71] = "8";
    $unicodeArray[71] = "0038";
    $chrArray[72] = "9";
    $unicodeArray[72] = "0039";
    $chrArray[73] = ":";
    $unicodeArray[73] = "003A";
    $chrArray[74] = ";";
    $unicodeArray[74] = "003B";
    $chrArray[75] = "<";
    $unicodeArray[75] = "003C";
    $chrArray[76] = "=";
    $unicodeArray[76] = "003D";
    $chrArray[77] = ">";
    $unicodeArray[77] = "003E";
    $chrArray[78] = "?";
    $unicodeArray[78] = "003F";
    $chrArray[79] = "@";
    $unicodeArray[79] = "0040";
    $chrArray[80] = "A";
    $unicodeArray[80] = "0041";
    $chrArray[81] = "B";
    $unicodeArray[81] = "0042";
    $chrArray[82] = "C";
    $unicodeArray[82] = "0043";
    $chrArray[83] = "D";
    $unicodeArray[83] = "0044";
    $chrArray[84] = "E";
    $unicodeArray[84] = "0045";
    $chrArray[85] = "F";
    $unicodeArray[85] = "0046";
    $chrArray[86] = "G";
    $unicodeArray[86] = "0047";
    $chrArray[87] = "H";
    $unicodeArray[87] = "0048";
    $chrArray[88] = "I";
    $unicodeArray[88] = "0049";
    $chrArray[89] = "J";
    $unicodeArray[89] = "004A";
    $chrArray[90] = "K";
    $unicodeArray[90] = "004B";
    $chrArray[91] = "L";
    $unicodeArray[91] = "004C";
    $chrArray[92] = "M";
    $unicodeArray[92] = "004D";
    $chrArray[93] = "N";
    $unicodeArray[93] = "004E";
    $chrArray[94] = "O";
    $unicodeArray[94] = "004F";
    $chrArray[95] = "P";
    $unicodeArray[95] = "0050";
    $chrArray[96] = "Q";
    $unicodeArray[96] = "0051";
    $chrArray[97] = "R";
    $unicodeArray[97] = "0052";
    $chrArray[98] = "S";
    $unicodeArray[98] = "0053";
    $chrArray[99] = "T";
    $unicodeArray[99] = "0054";
    $chrArray[100] = "U";
    $unicodeArray[100] = "0055";
    $chrArray[101] = "V";
    $unicodeArray[101] = "0056";
    $chrArray[102] = "W";
    $unicodeArray[102] = "0057";
    $chrArray[103] = "X";
    $unicodeArray[103] = "0058";
    $chrArray[104] = "Y";
    $unicodeArray[104] = "0059";
    $chrArray[105] = "Z";
    $unicodeArray[105] = "005A";
    $chrArray[106] = "[";
    $unicodeArray[106] = "005B";
    $char = "\ ";
    $chrArray[107] = trim($char);
    $unicodeArray[107] = "005C";
    $chrArray[108] = "]";
    $unicodeArray[108] = "005D";
    $chrArray[109] = "^";
    $unicodeArray[109] = "005E";
    $chrArray[110] = "_";
    $unicodeArray[110] = "005F";
    $chrArray[111] = "`";
    $unicodeArray[111] = "0060";
    $chrArray[112] = "a";
    $unicodeArray[112] = "0061";
    $chrArray[113] = "b";
    $unicodeArray[113] = "0062";
    $chrArray[114] = "c";
    $unicodeArray[114] = "0063";
    $chrArray[115] = "d";
    $unicodeArray[115] = "0064";
    $chrArray[116] = "e";
    $unicodeArray[116] = "0065";
    $chrArray[117] = "f";
    $unicodeArray[117] = "0066";
    $chrArray[118] = "g";
    $unicodeArray[118] = "0067";
    $chrArray[119] = "h";
    $unicodeArray[119] = "0068";
    $chrArray[120] = "i";
    $unicodeArray[120] = "0069";
    $chrArray[121] = "j";
    $unicodeArray[121] = "006A";
    $chrArray[122] = "k";
    $unicodeArray[122] = "006B";
    $chrArray[123] = "l";
    $unicodeArray[123] = "006C";
    $chrArray[124] = "m";
    $unicodeArray[124] = "006D";
    $chrArray[125] = "n";
    $unicodeArray[125] = "006E";
    $chrArray[126] = "o";
    $unicodeArray[126] = "006F";
    $chrArray[127] = "p";
    $unicodeArray[127] = "0070";
    $chrArray[128] = "q";
    $unicodeArray[128] = "0071";
    $chrArray[129] = "r";
    $unicodeArray[129] = "0072";
    $chrArray[130] = "s";
    $unicodeArray[130] = "0073";
    $chrArray[131] = "t";
    $unicodeArray[131] = "0074";
    $chrArray[132] = "u";
    $unicodeArray[132] = "0075";
    $chrArray[133] = "v";
    $unicodeArray[133] = "0076";
    $chrArray[134] = "w";
    $unicodeArray[134] = "0077";
    $chrArray[135] = "x";
    $unicodeArray[135] = "0078";
    $chrArray[136] = "y";
    $unicodeArray[136] = "0079";
    $chrArray[137] = "z";
    $unicodeArray[137] = "007A";
    $chrArray[138] = "{";
    $unicodeArray[138] = "007B";
    $chrArray[139] = "|";
    $unicodeArray[139] = "007C";
    $chrArray[140] = "}";
    $unicodeArray[140] = "007D";
    $chrArray[141] = "~";
    $unicodeArray[141] = "007E";
    $chrArray[142] = "�";
    $unicodeArray[142] = "00A9";
    $chrArray[143] = "�";
    $unicodeArray[143] = "00AE";
    $chrArray[144] = "�";
    $unicodeArray[144] = "00F7";
    $chrArray[145] = "�";
    $unicodeArray[145] = "00F7";
    $chrArray[146] = "�";
    $unicodeArray[146] = "00A7";
    $chrArray[147] = " ";
    $unicodeArray[147] = "0020";
    $chrArray[148] = "\n";
    $unicodeArray[148] = "000D";
    $chrArray[149] = "\r";
    $unicodeArray[149] = "000A";

    $strResult = "";
    for ($i = 0; $i < strlen($message); $i++) {
      if (in_array(substr($message, $i, 1), $chrArray))
        $strResult .= $unicodeArray[array_search(substr($message, $i, 1), $chrArray)];
    }
    return $strResult;
  }
}
