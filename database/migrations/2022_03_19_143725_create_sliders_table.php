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
    Schema::create('sliders', function (Blueprint $table) {
      $table->id();
      $table->boolean('status')->default(1); // default active
      $table->integer('order_column')->nullable();
      $table->string('image')->default('default.png');
      $table->string('link')->nullable();
      $table->foreignId('school_id')->nullable()->constrained()->onDelete('set null');

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
    Schema::dropIfExists('sliders');
  }
};
