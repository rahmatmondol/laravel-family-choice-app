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
    Schema::create('subscription_type_translations', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('appointment')->nullable();
      $table->string('locale')->index();
      $table->foreignId('sub_type_id')->nullable()->constrained('subscription_types')->onDelete('cascade');
      $table->unique(['sub_type_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('subscription_type_translations');
  }
};
