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
    Schema::create('customers', function (Blueprint $table) {
      $table->id();

      $table->string('full_name')->nullable();
      $table->string('email')->unique();
      $table->string('phone')->unique();
      $table->string('social_id')->nullable();
      $table->double('wallet')->default(0);
      $table->text('firebaseToken')->nullable();
      $table->boolean('status')->default(1); // default active

      $table->boolean('verified')->default(0);
      $table->integer('verification_code')->nullable(); // Active
      $table->integer('count_recieved_verification_code')->default('0'); // Active

      $table->enum('gender', ['male', 'female'])->nullable();
      $table->date('date_of_birth')->nullable();
      $table->string('image')->default('default.png');
      $table->timestamp('email_verified_at')->nullable();

      $table->string('password')->nullable();

      $table->double('lat')->nullable();
      $table->double('lng')->nullable();

      $table->string('stripe_customer_id')->nullable();
      $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');

      $table->rememberToken();
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
    Schema::dropIfExists('customers');
  }
};
