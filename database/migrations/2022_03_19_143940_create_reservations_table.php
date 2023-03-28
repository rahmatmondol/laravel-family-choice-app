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
      $table->string('parent_phone');
      $table->string('parent_date_of_birth')->nullable();
      $table->string('address');
      $table->double('total_fees')->nullable();
      $table->text('reason_of_refuse')->nullable();
      $table->text('partial_payment_info')->nullable();
      $table->text('remaining_payment_info')->nullable();
      $table->text('refund_partial_payment_info')->nullable();
      $table->enum('status', ReservationStatus::values())->default(ReservationStatus::Pending->value); // default active
      $table->enum('payment_status', PaymentStatus::values())->default(PaymentStatus::Pending->value)->nullable();
      $table->string('identification_number'); // text
      $table->string('payment_intent_id')->nullable(); // used for refund reservation
      $table->boolean('notification_is_sent')->default(false); // used for refund reservation
      $table->foreignId('school_id')->nullable()->constrained()->nullOnDelete();
      // $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
      $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
      $table->softDeletes();
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
