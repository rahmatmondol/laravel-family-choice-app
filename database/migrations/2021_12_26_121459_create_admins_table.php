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
    Schema::create('admins', function (Blueprint $table) {
      $table->id();
      $table->string('first_name');
      $table->string('last_name');
      $table->string('email')->nullable()->unique();
      $table->string('phone')->nullable()->unique();
      $table->integer('order_column')->nullable();

      $table->string('image')->default('default.png');

      $table->boolean('status')->default(1); // default active

      $table->timestamp('email_verified_at')->nullable();

      $table->string('password');

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
    Schema::dropIfExists('admins');
  }
};
