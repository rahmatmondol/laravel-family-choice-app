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
    Schema::create('schools', function (Blueprint $table) {

      $table->id();
      $table->boolean('status')->default(1); // default active

      $table->integer('order_column')->nullable();
      $table->string('phone')->nullable()->unique();
      $table->string('whatsapp')->nullable()->unique();
      $table->string('email')->unique();
      $table->integer('available_seats')->nullable();
      $table->integer('total_seats')->nullable();
      $table->double('review')->default(0);
      $table->integer('count_reviews')->default(0);
      $table->string('password');
      $table->string('image')->default('default.png');
      $table->string('cover')->default('default.png');

      $table->double('lat')->nullable();
      $table->double('lng')->nullable();

      $table->foreignId('type_id')->nullable()->constrained()->nullOnDelete();
      $table->softDeletes();
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
    Schema::dropIfExists('schools');
  }
};
