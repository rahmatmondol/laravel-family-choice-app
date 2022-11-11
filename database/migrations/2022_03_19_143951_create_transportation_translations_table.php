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
    Schema::create('transportation_translations', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('locale')->index();
      $table->foreignId('transportation_id')->constrained('transportations')->onDelete('cascade');
      $table->unique(['transportation_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('transportation_translations');
  }
};
