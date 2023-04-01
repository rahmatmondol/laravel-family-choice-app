<?php

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
        Schema::create('wallet_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['debit','credit']);
            $table->double('amount');
            $table->double('current_wallet');
            $table->text('description')->nullable();
            $table->integer('reservation_id')->nullable();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->boolean('customer_notified')->default(false); // notified with email notification
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
        Schema::dropIfExists('wallet_histories');
    }
};
