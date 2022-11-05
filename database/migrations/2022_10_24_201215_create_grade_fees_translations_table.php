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
    Schema::create('grade_fees_translations', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('locale')->index();
      $table->foreignId('grade_fees_id')->nullable()->constrained('grade_fees')->onDelete('cascade');
      $table->unique(['grade_fees_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('grade_fees_translations');
  }
};
