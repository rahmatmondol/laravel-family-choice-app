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
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('child_id');
            $table->text('photo')->nullable();
            $table->text('birth_certificate')->nullable();
            $table->text('health_card')->nullable();
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
        Schema::dropIfExists('student_documents');
    }
};
