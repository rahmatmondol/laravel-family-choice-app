<?php

namespace App\Console\Commands;

use App\Enums\PaymentStatus;
use App\Services\NotificationService;
use App\Services\Payment\PaymentService;
use App\Services\Reservation\ReservationService;
use Illuminate\Console\Command;

class HandlePaidReservations extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */


  protected $signature = 'handle:paidReservations';

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

    foreach (ReservationService::getPaidReservationsWillNotified() as $reservation) {

      PaymentService::createPaymentRecord($reservation->payment_intent_id);

      NotificationService::sendReservationNotification('payment_status.'.PaymentStatus::Succeeded->value, $reservation);

      ReservationService::makeReservationNotified($reservation);
    }
  }
}
