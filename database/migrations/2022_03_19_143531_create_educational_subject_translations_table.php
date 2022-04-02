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
    Schema::create('educational_subject_translations', function (Blueprint $table) {
      $table->id();

      $table->string('title')->unique();


      $table->string('locale')->index();
      $table->foreignId('educational_id')->nullable()->constrained('educational_subjects')->onDelete('cascade');
      $table->unique(['educational_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('educational_subject_translations');
  }
};
