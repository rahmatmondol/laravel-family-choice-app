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
    Schema::create('reviews', function (Blueprint $table) {
      $table->id();
      $table->double('follow_up')->nullable();
      $table->double('quality_of_education')->nullable();
      $table->double('cleanliness')->nullable();
      $table->string('comment')->nullable();

      $table->boolean('status')->default(1); // default active

      $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
      $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');

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
    Schema::dropIfExists('reviews');
  }
};
