<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incident_id')->nullable();
            $table->foreign('incident_id')->nullable()->references('id')->on('incidents')->onDelete('cascade');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')->nullable()->references('id')->on('questions')->onDelete('cascade');
            $table->longText('answers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions_answers');
    }
};
