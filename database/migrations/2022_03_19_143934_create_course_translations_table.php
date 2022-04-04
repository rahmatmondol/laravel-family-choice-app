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
    Schema::create('course_translations', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->text('short_description')->nullable();

      $table->string('locale')->index();
      $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
      $table->unique(['course_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('course_translations');
  }
};
