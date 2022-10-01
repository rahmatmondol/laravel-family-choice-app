<?php

use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_intent_id');
            $table->integer('reservation_id')->nullable();
            $table->enum('payment_status', PaymentStatus::values());
            $table->longText('event_object');
            $table->string('status')->default('pending'); // [pending  , done]   it's mean confirmed by our system  and update reservation's payment status
            $table->unique(['payment_intent_id', 'payment_status']);
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
        Schema::dropIfExists('payments');
    }
};
