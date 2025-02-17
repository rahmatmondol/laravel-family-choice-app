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
        // desable foreign key constraints
        Schema::disableForeignKeyConstraints();

        Schema::create('custoemr_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->string('child_name');
            $table->text('front_side');
            $table->text('back_side');
            $table->foreignId('user_document_folder_id')->constrained('user_document_folders')->onDelete('cascade');
            $table->timestamps();
        });

        // enable foreign key constraints
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custoemr_documents');
    }
};
