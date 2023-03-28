<?php

namespace App\Console\Commands;

use App\Enums\PaymentStatus;
use App\Services\NotificationService;
use App\Services\Payment\PaymentService;
use App\Services\Reservation\ReservationService;
use Exception;
use Illuminate\Console\Command;

class HandlePaymentReservation extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */

  protected $signature = 'handle:paymentReservation';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    foreach (ReservationService::getReservationsWillNotified() as $reservation) {

      PaymentService::createPaymentRecord($reservation,$reservation->payment_intent_id);

      NotificationService::sendReservationNotification('payment_status.' . $reservation->payment_status, $reservation);

      ReservationService::makeReservationNotified($reservation);
    }
  }
}
