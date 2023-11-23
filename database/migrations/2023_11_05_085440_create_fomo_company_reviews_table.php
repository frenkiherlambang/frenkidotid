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
        Schema::create('fomo_company_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->bigInteger('number_of_comments')->nullable();
            $table->bigInteger('number_of_dislikes')->nullable();
            $table->bigInteger('number_of_likes')->nullable();
            $table->longText('pros')->nullable();
            $table->longText('cons')->nullable();
            $table->string('job_title')->nullable();
            $table->float('rating')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('activity_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fomo_company_reviews');
    }
};
