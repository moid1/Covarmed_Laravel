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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prevention_advisor_id')->nullable();
            $table->foreign('prevention_advisor_id')->nullable()->references('id')->on('prevention_advisors')->onDelete('cascade');
            $table->string('employee_name')->nullable();
            $table->string('kit_use_reason')->nullable();
            $table->string('taken_from_kit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
