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
    // Schools or Nurseries
    Schema::create('types', function (Blueprint $table) {
      $table->id();
      $table->integer('order_column')->nullable();
      $table->boolean('status')->default(1); // default active
      $table->boolean('is_nursery')->default(false); /// default (true) is school
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
    Schema::dropIfExists('types');
  }
};
