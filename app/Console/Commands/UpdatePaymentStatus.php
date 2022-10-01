<?php

namespace App\Console\Commands;

use App\Models\Payment;
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
    foreach (Payment::where('status', 'pending')->get() as $payment) {

      $reservation_id = $this->getReservationId($payment);

      if (isset($reservation_id)) {
        $updated = ReservationService::updatePaymentStatus($reservation_id, $payment->payment_status);

        if($updated){
          // $payment->update(['status'=>'done','reservation_id'=>$reservation_id]);
        }
        info('reservation updated successfully');
      }

      if (isset($reservation_id) && isset($this->payment_intent_id)) {
        $updated = ReservationService::updatePaymentIntent($reservation_id, $this->payment_intent_id);

        if($updated){
          $payment->update(['status'=>'done','reservation_id'=>$reservation_id]);
        }
        info('reservation updated successfully');
      }

    }
  }

  public function getReservationId($payment)
  {
    $reservation_id = null;

    $paymentIntent = StripeService::retrievePaymentIntent($payment->payment_intent_id);

    info(print_r($paymentIntent,true));

    $this->payment_intent_id = $paymentIntent['id'];

    if (isset($payment->reservation_id)) {

      $reservation_id = $payment->reservation_id;

      info('get reservation id form payments table');

    } else {

      if (isset($paymentIntent->metadata->reservation_id)) {

        $reservation_id = $paymentIntent->metadata->reservation_id;
        
        info('get reservation id by payment intent');

      } else {

        info('reservation id not found');

      }
    }

    return $reservation_id;
  }
}
