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
        Schema::table('prevention_advisors', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('location');
            $table->dropColumn('logo');
            $table->dropColumn('company_name');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->nullable()->references('id')->on('companies')->onDelete('cascade');
            $table->boolean('is_verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prevention_advisors', function (Blueprint $table) {
            //
        });
    }
};
