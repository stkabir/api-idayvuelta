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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('highlights')->nullable();
            $table->string('destination');
            $table->string('duration'); // Ej: "4 horas", "Full Day"
            $table->unsignedInteger('max_people')->default(10);
            $table->decimal('price_adult', 10, 2);
            $table->decimal('price_child', 10, 2)->nullable();
            $table->json('included')->nullable(); // Lo que incluye el tour
            $table->json('not_included')->nullable();
            $table->json('itinerary')->nullable(); // Itinerario del tour
            $table->string('meeting_point')->nullable();
            $table->string('difficulty_level')->default('moderate'); // easy, moderate, hard
            $table->boolean('is_active')->default(true);
            $table->boolean('featured')->default(false);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
