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
    Schema::create('children', function (Blueprint $table) {
      $table->id();
      $table->string('child_name');
      $table->string('date_of_birth');
      $table->double('fees');
      $table->double('administrative_expenses')->nullable();
      $table->enum('gender', ['male', 'female'])->nullable();
      $table->foreignId('grade_id')->nullable()->constrained()->onDelete('cascade');
      $table->foreignId('reservation_id')->nullable()->constrained()->onDelete('cascade');
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
    Schema::dropIfExists('children');
  }
};
