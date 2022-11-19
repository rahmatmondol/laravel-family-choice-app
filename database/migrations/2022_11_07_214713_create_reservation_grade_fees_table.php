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
    Schema::create('reservation_grade_fees', function (Blueprint $table) {
      $table->id();
      $table->double('price');
      $table->foreignId('reservation_id')->nullable()->constrained()->nullOnDelete();
      $table->foreignId('grade_fees_id')->nullable()->constrained('grade_fees')->nullOnDelete();
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
    Schema::dropIfExists('reservation_grade_fees');
  }
};
