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
    Schema::create('grade_translations', function (Blueprint $table) {
      $table->id();

      $table->string('title')->unique();


      $table->string('locale')->index();
      $table->foreignId('grade_id')->nullable()->constrained()->onDelete('cascade');
      $table->unique(['grade_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('grade_translations');
  }
};
