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
    Schema::create('school_type_translations', function (Blueprint $table) {
      $table->id();

      $table->string('title');


      $table->string('locale')->index();
      $table->foreignId('school_type_id')->nullable()->constrained()->onDelete('cascade');
      $table->unique(['school_type_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('school_type_translations');
  }
};
