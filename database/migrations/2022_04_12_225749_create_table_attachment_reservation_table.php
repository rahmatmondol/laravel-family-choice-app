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
    Schema::create('table_attachment_reservation', function (Blueprint $table) {
      $table->id();
      $table->foreignId('attachment_id')->nullable()->constrained()->onDelete('cascade');
      $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
      $table->string('attachment');

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
    Schema::dropIfExists('table_attachment_reservation');
  }
};
