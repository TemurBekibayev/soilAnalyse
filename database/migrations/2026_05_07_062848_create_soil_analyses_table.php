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
        Schema::create('soil_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->onDelete('cascade');
            $table->decimal('ph', 4, 2)->nullable();
            $table->decimal('nitrogen', 8, 2)->nullable(); // mg/kg
            $table->decimal('phosphorus', 8, 2)->nullable(); // mg/kg
            $table->decimal('potassium', 8, 2)->nullable(); // mg/kg
            $table->decimal('organic_matter', 5, 2)->nullable(); // percentage
            $table->date('analysis_date');
            $table->string('status')->default('pending'); // pending, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soil_analyses');
    }
};
