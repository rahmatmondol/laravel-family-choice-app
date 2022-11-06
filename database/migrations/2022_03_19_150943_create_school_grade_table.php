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
    Schema::create('school_grade', function (Blueprint $table) {
      $table->id();
      $table->boolean('status')->default(1); // default active
      $table->foreignId('grade_id')->nullable()->constrained()->onDelete('cascade');
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
    Schema::dropIfExists('school_grade');
  }
};
