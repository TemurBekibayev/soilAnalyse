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
        Schema::table('soil_analyses', function (Blueprint $table) {
            // Add new fields
            $table->integer('fertility')->nullable()->after('ph'); // Max 3000
            $table->decimal('moisture', 5, 2)->nullable()->after('fertility'); // 0-99 %
            $table->decimal('temperature', 5, 2)->nullable()->after('moisture'); // 0-50 C
            $table->decimal('sunlight', 10, 2)->nullable()->after('temperature'); // 0-100,000 LUX
            $table->decimal('humidity', 5, 2)->nullable()->after('sunlight'); // 0-99 %

            // Remove old fields
            $table->dropColumn(['nitrogen', 'phosphorus', 'potassium', 'organic_matter']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soil_analyses', function (Blueprint $table) {
            $table->dropColumn(['fertility', 'moisture', 'temperature', 'sunlight', 'humidity']);
            $table->decimal('nitrogen', 8, 2)->nullable();
            $table->decimal('phosphorus', 8, 2)->nullable();
            $table->decimal('potassium', 8, 2)->nullable();
            $table->decimal('organic_matter', 5, 2)->nullable();
        });
    }
};
