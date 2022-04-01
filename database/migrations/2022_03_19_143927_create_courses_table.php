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
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->integer('order_column')->nullable();
      $table->boolean('status')->default(1); // default active
      $table->enum('type', ['summery', 'wintry']);
      $table->date('from_data');
      $table->date('to_data');
      $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
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
    Schema::dropIfExists('courses');
  }
};
