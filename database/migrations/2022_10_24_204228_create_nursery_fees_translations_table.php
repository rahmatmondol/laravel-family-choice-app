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
    Schema::create('nursery_fees_translations', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('locale')->index();
      $table->foreignId('nursery_fees_id')->nullable()->constrained('nursery_fees')->onDelete('cascade');
      $table->unique(['nursery_fees_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('nursery_fees_translations');
  }
};
