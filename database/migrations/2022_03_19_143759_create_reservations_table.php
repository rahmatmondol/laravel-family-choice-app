<?php

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('reservations', function (Blueprint $table) {
      $table->id();
      $table->string('parent_name');
      $table->string('address');
      $table->double('total_fees')->nullable();
      $table->text('reason_of_refuse')->nullable();
      $table->enum('status', ['pending', 'rejected', 'accepted'])->default(ReservationStatus::Pending->value); // default active
      $table->enum('payment_status', ['pending', 'failed', 'succeeded', 'refunded'])->default(PaymentStatus::Pending->value)->nullable();
      $table->string('identification_number'); // text
      $table->foreignId('school_id')->nullable()->constrained()->onDelete('set null');
      $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('reservations');
  }
};
