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
        Schema::create('fomo_companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->unsignedBigInteger('baseMonthlySalaryInRupiah')->nullable();
            $table->unsignedBigInteger('annualBonusInRupiah')->nullable();
            $table->string('roleLevel')->nullable();
            $table->integer('yearsOfExperience')->nullable();
            $table->string('jobTitle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fomo_companies');
    }
};
