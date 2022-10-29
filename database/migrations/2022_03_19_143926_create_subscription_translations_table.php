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
    Schema::create('subscription_translations', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('short_description')->nullable();
      $table->string('locale')->index();
      $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('cascade');
      $table->unique(['subscription_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('subscription_translations');
  }
};
