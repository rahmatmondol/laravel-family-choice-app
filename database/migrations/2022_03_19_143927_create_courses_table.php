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
    Schema::create('courses', function (Blueprint $table) {
      $table->id();

      $table->integer('order_column')->nullable();
      $table->string('image')->default('default.png');
      $table->boolean('status')->default(1); // default active
      $table->enum('type', ['summery', 'wintry'])->nullable();
      $table->date('from_date');
      $table->date('to_date');
      $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
      $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('courses');
  }
};
