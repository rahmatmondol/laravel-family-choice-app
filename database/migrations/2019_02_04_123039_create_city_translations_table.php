<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('city_translations', function (Blueprint $table) {
      $table->id();

      $table->string('title')->unique();

      $table->string('locale')->index();
      $table->foreignId('city_id')->nullable()->constrained()->onDelete('cascade');
      $table->unique(['city_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('city_translations');
  }
};
