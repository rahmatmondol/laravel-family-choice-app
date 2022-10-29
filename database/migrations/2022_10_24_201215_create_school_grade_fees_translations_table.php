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
    Schema::create('school_grade_fees_translations', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('locale')->index();
      $table->foreignId('sc_gr_fees_id')->nullable()->constrained('school_grade_fees')->onDelete('cascade');
      $table->unique(['sc_gr_fees_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('school_grade_fees_translations');
  }
};
