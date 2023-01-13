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
    Schema::create('children', function (Blueprint $table) {
      $table->id();
      $table->double('total_fees')->nullable();
      $table->string('child_name');
      $table->string('date_of_birth');
      $table->double('subscription_type_price')->nullable();
      $table->double('transportation_price')->nullable();
      $table->enum('gender', ['male', 'female'])->nullable();
      $table->foreignId('grade_id')->nullable()->constrained()->nullOnDelete();
      $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
      $table->foreignId('subscription_type_id')->nullable('subscription_types')->constrained()->nullOnDelete();
      $table->foreignId('transportation_id')->nullable()->constrained('transportations')->nullOnDelete();
      $table->foreignId('reservation_id')->nullable()->constrained()->onDelete('cascade');
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
    Schema::dropIfExists('children');
  }
};
