<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Services\Payment\PaymentService;
use App\Services\Payment\StripeService;
use App\Services\Reservation\ReservationService;
use Illuminate\Console\Command;

class UpdatePaymentStatus extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */

  
  protected $signature = 'update:paymentStatus';

  protected $payment_intent_id  = null;

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'update payment status reservations table';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {

    foreach (ReservationService::getReservationPaidWillNotified() as $reservation) {

      PaymentService::createPaymentRecord($reservation->payment_intent_id);

      // ReservationService::handleReservationNotification($reservation,$reservation->status);
    }
  }
}
